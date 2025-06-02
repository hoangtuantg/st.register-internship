<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Models\Campaign;
use App\Services\SsoService;
use App\Models\GroupOfficial;
use App\Enums\ReportStatusEnum;

class DashboardController extends Controller
{
    public function index()
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        //Số lượng chiến dịch đang hoạt động
        $campaign = Campaign::query()
            ->where('faculty_id', $facultyId)
            ->where('status', StatusEnum::Active->value)
            ->count();

        //Tổng số nhóm chính thức
        $totalGroups = GroupOfficial::query()
            ->whereHas('campaign', function ($query) use ($facultyId) {
                $query->where('faculty_id', $facultyId)
                    ->where('status', StatusEnum::Active->value);
            })
            ->count();

        //Số lượng báo cáo đã nộp
        $submittedGroupCount = GroupOfficial::query()
            ->whereHas('campaign', function ($query) use ($facultyId) {
                $query->where('faculty_id', $facultyId)
                    ->where('status', StatusEnum::Active->value);
            })
            ->whereNotNull('report_file')
            ->count();
            
        //Tính tỷ lệ phần trăm báo cáo đã nộp
        $submittedPercent = $totalGroups > 0 ? round($submittedGroupCount / $totalGroups * 100) : 0;

        //Số lượng báo cáo đã duyệt
        $approvedReportCount = GroupOfficial::query()
            ->whereHas('campaign', function ($query) use ($facultyId) {
                $query->where('faculty_id', $facultyId)
                    ->where('status', StatusEnum::Active->value);
            })
            ->where('report_status', ReportStatusEnum::APPROVED->value)
            ->count();

        //Tính tỷ lệ phần trăm báo cáo đã duyệt
        $approvedPercent = $totalGroups > 0 ? round($approvedReportCount / $totalGroups * 100) : 0;
        return view(
            'pages/admin/dashboard',
            [
                'campaign' => $campaign,
                'submittedGroupCount' => $submittedGroupCount,
                'totalGroups' => $totalGroups,
                'submittedPercent' => $submittedPercent,
                'approvedReportCount' => $approvedReportCount,
                'approvedPercent' => $approvedPercent,
            ]
        );
    }
}
