<?php

namespace App\Livewire\Admin\Teacher;

use Livewire\Component;
use App\Models\Teacher;
use App\Services\SsoService;
use App\Enums\TeacherStatusEnum;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Common\Constants;
use Livewire\WithPagination;

class TeacherIndex extends Component
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

        $teachers = Teacher::query()
            ->where('faculty_id', $facultyId)
            ->orderBy('created_at', 'desc')
            ->search($this->search)
            ->paginate(Constants::PER_PAGE_ADMIN);

        // $teachers = $this->fetchData();
        return view('livewire.admin.teacher.teacher-index', [
            'teachers' => $teachers,
        ]);
    }

    public function placeholder()
    {
        return view('components.placeholders.table-placeholder');
    }

    public function accept($teacherId): void
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            $teacher->status = TeacherStatusEnum::Accept->value;
            $teacher->save();
        }
    }

    public function pause($teacherId): void
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            $teacher->status = TeacherStatusEnum::Refuse->value;
            $teacher->save();
        }
    }

    #[On('onPageChange')]
    public function onUpdatePage($page): void
    {
        $this->page = (int) $page;
    }

    public function syncFromSso(): void
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        $page = 1;
        $allTeachersFromApi = [];

        do {
            $responses = app(SsoService::class)->get("/api/faculties/{$facultyId}/teachers", ['page' => $page]);
            $teachersFromApi = @$responses['data'] ?? [];
            $meta = @$responses['meta'] ?? [];

            $allTeachersFromApi = array_merge($allTeachersFromApi, $teachersFromApi);
            $page++;
        } while (!empty($teachersFromApi) && $meta['current_page'] < $meta['last_page']);

        $ssoIds = collect($allTeachersFromApi)->pluck('id')->toArray();

        // Lấy user theo sso_id
        $localUsers = User::whereIn('sso_id', $ssoIds)->get()->keyBy('sso_id');

        foreach ($allTeachersFromApi as $teacherData) {
            $ssoId = $teacherData['id'];
            $localUser = $localUsers[$ssoId] ?? null;

            if ($localUser) {
                // Kiểm tra giảng viên đã tồn tại chưa
                $teacher = Teacher::where('user_id', $localUser->id)->first();

                if ($teacher) {
                    // Giữ nguyên status, chỉ cập nhật thông tin khác nếu cần
                    $teacher->update([
                        'code'       => $teacherData['code'] ?? $teacher->code,
                        'name'       => $teacherData['full_name'] ?? $teacher->name,
                        'faculty_id' => $teacher->faculty_id ?? $facultyId,
                    ]);
                } else {
                    // Nếu chưa có thì tạo mới
                    Teacher::create([
                        'user_id'    => $localUser->id,
                        'faculty_id' => $facultyId,
                        'status'     => TeacherStatusEnum::Accept->value,
                        'code'       => $teacherData['code'] ?? null,
                        'name'       => $teacherData['full_name'] ?? null,
                    ]);
                }
            }
        }

        $this->dispatch('alert', type: 'success', message: 'Cập nhật thành công!');
    }
}
