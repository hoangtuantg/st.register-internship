<?php

namespace App\Livewire\Admin\Report;

use Livewire\Component;
use App\Models\GroupOfficial;
use App\Common\Constants;
use Illuminate\Support\Str;
use App\Services\SsoService;
use App\Models\Teacher;
use App\Models\User;

class ReportShow extends Component
{
    public int|string $campaignId = '';

    public string $search = '';

    protected $teacherId = null;

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;

        // Lấy mã người dùng đăng nhập từ SSO
        $code = app(SsoService::class)->getDataUser()['code'] ?? '';

        // Tìm giảng viên theo mã
        $teacher = Teacher::where('code', $code)->first();

        // Nếu không tìm thấy thì không hiển thị nhóm nào cả
        if ($teacher) {
            $this->teacherId = $teacher->id;
        }
    }

    public function render()
    {
        /** @var User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $groups = GroupOfficial::where('campaign_id', $this->campaignId)
            ->when(!$user->isSuperAdmin() && $this->teacherId, function ($query) {
                $query->where('teacher_id', $this->teacherId);
            })
            ->search($this->search)
            ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.admin.report.report-show', [
            'groups' => $groups
        ]);
    }

    public function downloadReport($groupId)
    {
        $group = GroupOfficial::findOrFail($groupId);

        $filePath = storage_path('app/public/' . $group->report_file);

        $extension = pathinfo($group->report_file, PATHINFO_EXTENSION);

        $campaignName = $group->campaign->name;
        $campaignName = strtoupper(Str::slug($campaignName, '_'));

        $fileName = "BAO_CAO_{$campaignName}_NHOM_{$group->code}.{$extension}";

        return response()->download($filePath, $fileName);
    }

    public function approveReport($groupId)
    {
        $group = GroupOfficial::findOrFail($groupId);
        $group->update(['report_status' => \App\Enums\ReportStatusEnum::APPROVED->value]);
    }

    public function rejectReport($groupId)
    {
        $group = GroupOfficial::findOrFail($groupId);
        $group->update(['report_status' => \App\Enums\ReportStatusEnum::REJECTED->value]);
    }
}
