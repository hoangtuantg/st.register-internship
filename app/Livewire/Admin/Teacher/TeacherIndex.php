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

    public function fetchData()
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        $params = [
            'page' => $this->page,
        ];

        if ($this->search) {
            $params['search'] = $this->search;
        }

        $responses = app(SsoService::class)->get("/api/faculties/{$facultyId}/teachers", $params);
        $this->page = @$responses['meta']['current_page'] ?? 1;
        $this->totalPages = @$responses['meta']['last_page'] ?? 1;
        $teachersFromApi = @$responses['data'] ?? [];

        $ssoIds = collect($teachersFromApi)->pluck('id')->toArray();

        // Lấy user dựa trên sso_id
        $localUsers = User::whereIn('sso_id', $ssoIds)->get()->keyBy('sso_id');

        $teachers = collect($teachersFromApi)->map(function ($teacher) use ($localUsers, $facultyId) {
            $localUser = $localUsers[$teacher['id']] ?? null;

            if ($localUser) {
                // Kiểm tra lại thông tin user_id và faculty_id
                if (!$localUser->id || !$facultyId) {
                    logger("Lỗi: Không có user_id hoặc faculty_id", ['user_id' => $localUser->id, 'faculty_id' => $facultyId]);
                }

                // Nếu user đã có, thì tạo teacher nếu chưa có
                $teacherRecord = Teacher::firstOrCreate([
                    'user_id' => $localUser->id,
                ], [
                    'user_id'    => $localUser->id,
                    'faculty_id' => $facultyId,
                    'status'     => TeacherStatusEnum::Accept->value,
                    'code'       => $teacher['code'] ?? null,
                    'name'       => $teacher['full_name'] ?? null,
                ]);

                // Kiểm tra xem bản ghi đã được tạo hay chưa
                if ($teacherRecord->wasRecentlyCreated) {
                    logger("Đã tạo mới giảng viên: " . $localUser->id);
                } else {
                    logger("Giảng viên đã tồn tại: " . $localUser->id);
                }
                //Status nhận/ dừng nhận hướng dẫn trên local
                $teacher['local_status'] = $teacherRecord->status;
            }
            return $teacher;
        })->toArray();


        return $teachers;
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

    // public function accept($teacherId)
    // {
    //     // Tìm user theo sso_id
    //     $user = User::where('sso_id', $teacherId)->first();

    //     if ($user) {
    //         // Tìm giảng viên theo user_id
    //         $teacher = Teacher::where('user_id', $user->id)->first();

    //         if ($teacher) {
    //             // Cập nhật trạng thái
    //             $teacher->update(['status' => TeacherStatusEnum::Accept->value]);
    //         }
    //     }
    // }

    // public function pause($teacherId)
    // {
    //     // Tìm user theo sso_id
    //     $user = User::where('sso_id', $teacherId)->first();

    //     if ($user) {
    //         // Tìm giảng viên theo user_id
    //         $teacher = Teacher::where('user_id', $user->id)->first();

    //         if ($teacher) {
    //             // Cập nhật trạng thái
    //             $teacher->update(['status' => TeacherStatusEnum::Refuse->value]);
    //         }
    //     }
    // }
}
