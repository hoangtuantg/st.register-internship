<?php

namespace App\Livewire\Client\Research;

use Livewire\Component;
use App\Common\Constants;
use App\Models\Campaign;
use App\Models\Group;
use App\Models\GroupKey;
use App\Models\GroupOfficial;
use App\Models\PlanDetail;
use App\Models\Student;
use App\Models\StudentGroupOfficial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use App\Services\SsoService;

class ClientResearchOfficial extends Component
{
    public int|string $campaignId;

    public bool $isLoading = false;

    public $groupOfficial;

    // public $group;

    public $isCaptain;

    public $student;

    public string $code = '';

    public $reportDeadline;

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
        $this->code = app(SsoService::class)->getStudentCode();
        $this->student = Student::query()
            ->where('code', $this->code)
            ->where('campaign_id', $this->campaignId)
            ->whereNotNull('group_official_id')
            ->first();

        if (! $this->student) {
            $this->dispatch('alert', type: 'error', message: 'Không tìm thấy nhóm tương ứng');

            return;
        }

        $this->groupOfficial = GroupOfficial::query()
            ->where('id', $this->student->group_official_id)
            ->with(['students', 'students.studentGroupOfficial'])
            ->first();

        $this->isCaptain = $this->groupOfficial->captain->code;

        $this->reportDeadline = $campaignId
            ? Carbon::parse($this->student->campaign->report_deadline)->format('d/m/Y')
            : null;
    }

    public function render()
    {
        $campaign = Campaign::with('planTemplate')->find($this->campaignId);
        $plans = PlanDetail::query()
            ->where('plan_id', $campaign->planTemplate->id ?? null)
            ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.client.research.client-research-official', [
            'campaign' => $campaign,
            'plans' => $plans,
            'planName' => $campaign->planTemplate->name ?? 'Chưa có kế hoạch',
            'reportDeadline' => $this->reportDeadline,
        ]);
    }

    public function openPlanModal()
    {
        $this->dispatch('open-plan-modal');
    }

    public function editGroupOfficial()
    {
        if (! $this->student->studentGroupOfficial->is_captain) {
            return;
        }

        if (! $this->isLoading) {
            $this->isLoading = true;
            try {
                $groupKey = GroupKey::create([
                    'group_id' => $this->groupOfficial->id,
                    'key' => Str::random(),
                    'group_type' => GroupOfficial::class,
                ]);

                $groupKey->active = true;
                $groupKey->save();

                return redirect()->route('internship.edit', ['key' => $groupKey->key]);
            } catch (\Exception $exception) {
                Log::error('Redirect to edit with group official key failed', [
                    'message' => $exception->getMessage(),
                ]);
                $this->dispatch('alert', type: 'error', message: 'Có lỗi xảy ra vui lòng thử lại sau!');
            }
            $this->isLoading = false;
        }
    }

    public function sendReport()
    {
        if (! $this->student->studentGroupOfficial->is_captain) {
            return;
        }
        if (!$this->isLoading) {
            $this->isLoading = true;
            try {
                $groupKey = GroupKey::create([
                    'group_id' => $this->groupOfficial->id,
                    'key' => Str::random(),
                    'group_type' => GroupOfficial::class
                ]);

                $groupKey->active = true;
                $groupKey->save();

                return redirect()->route('internship.report', ['key' => $groupKey->key]);

                $this->dispatch('alert', type: "success", message: "Hệ thống đã gửi yêu cầu nộp báo cáo. Vui lòng check email bạn đã đăng ký để có thể nhận mã yêu cầu!");
            } catch (\Exception $exception) {
                Log::error('Redirect to send report with group official key failed', [
                    'message' => $exception->getMessage(),
                ]);
                $this->dispatch('alert', type: "error", message: "Có lỗi sảy ra vui lòng thử lại sau!");
            }
            $this->isLoading = false;
        }
    }
}
