<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Services\SsoService;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Common\Constants;

class UserIndex extends Component
{
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

    public function fetchData()
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        $params = [
            'page' => $this->page,
        ];

        if ($this->search) {
            $params['search'] = $this->search;
        }

        $responses = app(SsoService::class)->get("/api/faculties/{$facultyId}/users", $params);
        $this->page = @$responses['meta']['current_page'] ?? 1;
        $this->totalPages = @$responses['meta']['last_page'] ?? 1;
        $usersFromApi = @$responses['data'] ?? [];

        $ssoIds = collect($usersFromApi)->pluck('id')->toArray();

        $localUsers = User::whereIn('sso_id', $ssoIds)->get()->keyBy('sso_id');

        $users = collect($usersFromApi)->map(function ($user) use ($localUsers) {
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

            if (!$localUser) {
                $localUser = User::create($userData);
            } else {
                $localUser->update($userData);
            }

            $user['local_user'] = $localUser->toArray();
            return $user;
        })->toArray();

        return $users;
    }

    #[On('onPageChange')]
    public function onUpdatePage($page): void
    {
        $this->page = (int) $page;
    }
}
