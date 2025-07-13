<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Models\Campaign;
use App\Services\SsoService;
use App\Models\GroupOfficial;
use App\Enums\ReportStatusEnum;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        // Lấy tất cả các campaign đang hoạt động
        $activeCampaigns = Campaign::query()
            ->where('faculty_id', $facultyId)
            ->where('status', StatusEnum::Active->value)
            ->get();

        //Số lượng chiến dịch đang hoạt động
        $campaign = $activeCampaigns->count();

        // Tạo dữ liệu cho từng campaign
        $campaignData = [];
        foreach ($activeCampaigns as $activeCampaign) {
            //Tổng số nhóm chính thức của campaign này
            $totalGroups = GroupOfficial::query()
                ->where('campaign_id', $activeCampaign->id)
                ->count();

            //Số lượng báo cáo đã nộp của campaign này
            $submittedGroupCount = GroupOfficial::query()
                ->where('campaign_id', $activeCampaign->id)
                ->whereNotNull('report_file')
                ->count();

            //Số lượng báo cáo đã duyệt của campaign này
            $approvedReportCount = GroupOfficial::query()
                ->where('campaign_id', $activeCampaign->id)
                ->where('report_status', ReportStatusEnum::APPROVED->value)
                ->whereNotNull('report_file')
                ->count();
            //Số lượng báo cáo bị từ chối của campaign này
            $rejectedReportCount = GroupOfficial::query()
                ->where('campaign_id', $activeCampaign->id)
                ->where('report_status', ReportStatusEnum::REJECTED->value)
                ->whereNotNull('report_file')
                ->count();
            //Số lượng báo cáo chờ duyệt của campaign này
            $pendingReportCount = GroupOfficial::query()
                ->where('campaign_id', $activeCampaign->id)
                ->where('report_status', ReportStatusEnum::PENDING->value)
                ->whereNotNull('report_file')
                ->count();

            //Tính tỷ lệ phần trăm
            $submittedPercent = $totalGroups > 0 ? round($submittedGroupCount / $totalGroups * 100) : 0;
            $approvedPercent = $totalGroups > 0 ? round($approvedReportCount / $totalGroups * 100) : 0;
            $rejectedPercent = $totalGroups > 0 ? round($rejectedReportCount / $totalGroups * 100) : 0;
            $pendingPercent = $totalGroups > 0 ? round($pendingReportCount / $totalGroups * 100) : 0;

            // Sinh viên đã đăng ký thực tập
            $totalStudents = Student::where('campaign_id', $activeCampaign->id)->count();
            $registeredStudents = Student::where('campaign_id', $activeCampaign->id)
                ->whereNotNull('group_id')->count();
            $unregisteredStudents = $totalStudents - $registeredStudents;
            $campaignData[] = [
                'id' => $activeCampaign->id,
                'name' => $activeCampaign->name,
                'totalGroups' => $totalGroups,
                'submittedGroupCount' => $submittedGroupCount,
                'approvedReportCount' => $approvedReportCount,
                'submittedPercent' => $submittedPercent,
                'approvedPercent' => $approvedPercent,
                'notSubmitted' => $totalGroups - $submittedGroupCount,
                'notApproved' => $submittedGroupCount - $approvedReportCount,
                'rejectedReportCount' => $rejectedReportCount,
                'rejectedPercent' => $rejectedPercent,
                'pendingReportCount' => $pendingReportCount,
                'pendingPercent' => $pendingPercent,
                'report_deadline' => $activeCampaign->report_deadline,
                'register_end' => $activeCampaign->end,



                'totalStudents' => $totalStudents,
                'registeredStudents' => $registeredStudents,
                'unregisteredStudents' => $unregisteredStudents,

            ];
        }

        // Tính tổng cho tất cả campaigns
        $totalGroups = collect($campaignData)->sum('totalGroups');
        $submittedGroupCount = collect($campaignData)->sum('submittedGroupCount');
        $approvedReportCount = collect($campaignData)->sum('approvedReportCount');
        $submittedPercent = $totalGroups > 0 ? round($submittedGroupCount / $totalGroups * 100) : 0;
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
                // 'activeCampaigns' => $activeCampaigns->pluck('name'),
                'activeCampaigns' => $activeCampaigns->map(function ($c) {
                    return [
                        'id' => $c->id,
                        'name' => $c->name,
                    ];
                })->values(),
                'campaignData' => $campaignData,
            ]
        );
    }
}
