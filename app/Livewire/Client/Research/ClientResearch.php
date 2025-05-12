<?php

namespace App\Livewire\Client\Research;

use Livewire\Component;
use App\Common\Constants;
use App\Jobs\SendRequestEditMailJob;
use App\Mail\RequestEditMail;
use App\Models\Campaign;
use App\Models\Group;
use App\Models\GroupKey;
use App\Models\PlanDetail;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use App\Services\SsoService;

class ClientResearch extends Component
{
    public int|string $campaignId;

    public bool $isLoading = false;

    public $group;

    public $isCaptain;

    public $student;

    public string $code = '';

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
        $this->code = app(SsoService::class)->getStudentCode();

        // Tìm sinh viên trong đợt đăng ký này
        $this->student = Student::query()
            ->where('code', $this->code)
            ->where('campaign_id', $this->campaignId)
            ->whereNotNull('group_id')
            ->first();

        if (! $this->student) {
            $this->dispatch('alert', type: 'error', message: 'Không tìm thấy nhóm tương ứng');

            return;
        }

        $this->group = Group::query()
            ->where('id', $this->student->group_id)
            ->with(['students', 'students.groupStudent'])
            ->first();

        $this->isCaptain = $this->group->captain->code;
    }

    public function render()
    {
        $campaign = Campaign::with('planTemplate')->find($this->campaignId);
        $plans = PlanDetail::query()
            ->where('plan_id', $campaign->planTemplate->id ?? null)
            ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.client.research.client-research', [
            'campaign' => $campaign,
            'plans' => $plans,
            'planName' => $campaign->planTemplate->name ?? 'Chưa có kế hoạch',
        ]);
    }

    public function openPlanModal()
    {
        $this->dispatch('open-plan-modal');
    }
}
