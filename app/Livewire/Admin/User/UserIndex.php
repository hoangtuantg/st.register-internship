<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Services\SsoService;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Common\Constants;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    #[Url]
    public int $page = 1;

    public int $totalPages = 0;

    #[Url(as: 'q')]
    public ?string $search = '';

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        $users = User::query()
            ->with('userRoles')
            ->where('faculty_id', $facultyId)
            ->orderBy('created_at', 'desc')
            ->search($this->search)
            ->paginate(Constants::PER_PAGE_ADMIN);
        // $users = $this->fetchData();

        return view('livewire.admin.user.user-index', [
            'users' => $users,
        ]);
    }

    public function placeholder()
    {
        return view('components.placeholders.table-placeholder');
    }


    #[On('onPageChange')]
    public function onUpdatePage($page): void
    {
        $this->page = (int) $page;
    }

    public function syncFromSso()
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        $page = 1;

        do {
            $params = [
                'page' => $page,
            ];

            $responses = app(SsoService::class)->get("/api/faculties/{$facultyId}/users", $params);

            $usersFromApi = $responses['data'] ?? [];

            $ssoIds = collect($usersFromApi)->pluck('id')->toArray();

            $localUsers = User::whereIn('sso_id', $ssoIds)->get()->keyBy('sso_id');

            foreach ($usersFromApi as $user) {
                $localUser = $localUsers[$user['id']] ?? null;

                $userData = [
                    'sso_id'     => $user['id'],
                    'full_name'  => $user['full_name'] ?? null,
                    'code'       => $user['code'] ?? null,
                    'faculty_id' => $user['faculty_id'] ?? null,
                    'role'       => $user['role'] ?? null,
                    'user_data'  => json_encode($user),
                    'status'     => StatusEnum::Active->value,
                ];

                // Giữ nguyên status nếu đã có user
                if ($localUser) {
                    $userData['status'] = $localUser->status;
                    $localUser->update($userData);
                } else {
                    $userData['status'] = StatusEnum::Active->value;
                    User::create($userData);
                }
            }

            $page++;
            $lastPage = $responses['meta']['last_page'] ?? 1;
        } while ($page <= $lastPage);

        $this->dispatch('alert', type: 'success', message: 'Cập nhật thành công!');
    }
}
