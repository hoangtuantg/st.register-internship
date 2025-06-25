<?php

namespace App\Imports;

use App\Enums\StudentAttributesEnum;
use App\Models\Course;
use App\Models\Group;
use App\Models\GroupOfficial;
use App\Models\GroupStudent;
use App\Models\Student;
use App\Models\StudentGroupOfficial;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GroupStudentOfficalImport implements ToCollection, WithStartRow, WithHeadingRow
{

    public function __construct(private int|string $campaignId) {}


    public const START_ROW = 3;
    public const HEADER_INDEX = 2;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        DB::beginTransaction();
        try {
            // Xóa toàn bộ dữ liệu liên quan trước khi import mới
            StudentGroupOfficial::whereHas('student', function ($query) {
                $query->where('campaign_id', $this->campaignId);
            })->delete();

            GroupOfficial::where('campaign_id', $this->campaignId)->delete();

            Student::where('campaign_id', $this->campaignId)->update(['group_official_id' => null]);


            foreach ($collection as $row) {
                $student = Student::query()
                    ->where('code', $row['ma_sinh_vien'])
                    ->where('campaign_id', $this->campaignId)
                    ->first();

                if ($student && !$student->email) {
                    $student->update([
                        'email' => $row['email'],
                    ]);
                }

                if (!$student) {
                    Log::error('student offical import not found ' . $row['ma_sinh_vien']);
                    continue;
                }

                // Lấy thông tin từ nguyện vọng nếu Excel không có
                $groupStudent = GroupStudent::where('student_id', $student->id)->first();

                $internship_company = $row['cong_ty_thuc_tap'] ?: $groupStudent?->internship_company;
                $supervisor_company = $row['ho_ten_can_bo_huong_dan_tai_co_so_thuc_tap'] ?: $groupStudent?->supervisor_company;
                $supervisor_company_email = $row['email_cua_can_bo_huong_dan_tai_co_so_thuc_tap'] ?: $groupStudent?->supervisor_company_email;
                $supervisor_company_phone = $row['so_dien_thoai_cua_can_bo_huong_dan_tai_co_so_thuc_tap'] ?: $groupStudent?->supervisor_company_phone;
                $email = $row['email'] ?: $groupStudent?->email;
                $phone = $row['so_dien_thoai'] ?: $groupStudent?->phone;
                $phone_family = $row['so_dien_thoai_phu_huynh'] ?: $groupStudent?->phone_family;

                $group = GroupOfficial::query()
                    ->where('code', $row['nhom'])
                    ->where('campaign_id', $this->campaignId)
                    ->first();

                $teacher = Teacher::query()->where('code', $row['ma_gv'])->first();


                // $dataTeacher = [
                //     'code' => $row['ma_gv'],
                //     'name' => $row['phan_cong_giao_vien_huong_dan'],
                // ];

                // if (!empty($row['email_cua_giao_vien_huong_dan'])) {
                //     $dataTeacher['email'] = $row['email_cua_giao_vien_huong_dan'];
                // }

                // if (!empty($row['so_dien_thoai_cua_giao_vien_huong_dan'])) {
                //     $dataTeacher['phone'] = $row['so_dien_thoai_cua_giao_vien_huong_dan'];
                // }

                // if (!$teacher) {
                //     $teacher = Teacher::create($dataTeacher);
                // } else {
                //     Teacher::where('id', $teacher->id)->update($dataTeacher);
                // }


                if (!$group) {
                    $group = GroupOfficial::create([
                        'code' => $row['nhom'],
                        'campaign_id' => $this->campaignId,
                        'department' => $row['bo_mon_quan_ly'],
                        'teacher_id' => $teacher?->id,
                        'supervisor' => $row['phan_cong_giao_vien_huong_dan'] ?:$student->group?->supervisor,
                        'topic' => $row['de_tai_thuc_tap'] ?: null
                    ]);
                } else {
                    GroupOfficial::where('id', $group->id)->update([
                        'code' => $row['nhom'],
                        'campaign_id' => $this->campaignId,
                        'department' => $row['bo_mon_quan_ly'],
                        'teacher_id' => $teacher?->id,
                        'supervisor' => $row['phan_cong_giao_vien_huong_dan'] ?: $student->group?->supervisor,
                        'topic' => $row['de_tai_thuc_tap'] ?: null
                    ]);
                }


                Student::query()->where('id', $student->id)->update([
                    'group_official_id' => $group->id,
                ]);


                $countStudent = $group->students()->count();
                $isCaptain = ($countStudent == 0) || (!empty($row['nhom_truong']) && trim($row['nhom_truong']) === '*');
                if ($isCaptain) {
                    StudentGroupOfficial::whereHas('student', function ($query) use ($group) {
                        $query->where('group_official_id', $group->id);
                    })->update(['is_captain' => false]);
                }

                StudentGroupOfficial::updateOrCreate(
                    ['student_id' => $student->id],
                    [
                        'student_id' => $student->id,
                        'internship_company' => $internship_company,
                        'email' => $email,
                        'phone_family' => $phone_family,
                        'phone' => $phone,
                        'supervisor_company' => $supervisor_company,
                        'supervisor_company_email' => $supervisor_company_email,
                        'supervisor_company_phone' => $supervisor_company_phone,
                        'is_captain' => $isCaptain,
                    ]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error('Error import student group official', [
                'message' => $e->getMessage(),
            ]);
            DB::rollBack();
            throw $e;
        }
    }


    public function startRow(): int
    {
        return self::START_ROW;
    }

    public function headingRow(): int
    {
        return self::HEADER_INDEX;
    }
}
