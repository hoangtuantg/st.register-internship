<?php

namespace App\Livewire\Admin\Campaign;

use Livewire\Component;

use App\Common\Constants;
use App\Enums\CampaignStatusEnum;
use App\Models\Campaign;
use App\Models\Plan;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use App\Services\SsoService;
use Illuminate\Support\Facades\Gate;


class CampaignUpdate extends Component
{
    public int|string $campaignId;

    #[Validate(as: 'tên đợt đợt đăng ký')]
    public string $name = '';

    #[Validate('required', as: 'ngày bắt đầu')]
    public string $start = '';

    #[Validate('required', as: 'ngày kết thúc')]
    public string $end = '';

    #[Validate( as: 'số lượng thành viên trong nhóm')]
    public int $max_student_group = 0;

    public string  $official_end = '';

    public int|string|null $planId;

    public bool $isLoading = false;

    public string $status;

    public string $report_deadline = '';

    protected $listeners = [
        'update-start-date' => 'updateStartDate',
        'update-end-date' => 'updateEndDate',
        'update-official-end-date' => 'updateOfficialEndDate',
        'selectedPlan' => 'updatePlan',
        'update-report-deadline' => 'updateReportDeadline',
    ];

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();
        $planTemplates = Plan::where('faculty_id', $facultyId)->get();
        return view('livewire.admin.campaign.campaign-update', [
            'planTemplates' => $planTemplates,
        ]);
    }

    public function mount($id)
    {
        $campaign = Campaign::query()->find($id);
        $this->campaignId = $id;
        $this->name = $campaign->name;
        $this->start = Carbon::make($campaign->start)->format(Constants::FORMAT_DATE);
        $this->end = Carbon::make($campaign->end)->format(Constants::FORMAT_DATE);
        $this->official_end = Carbon::make($campaign->official_end ?? now())->format(Constants::FORMAT_DATE);
        $this->report_deadline = Carbon::make($campaign->report_deadline ?? now())->format(Constants::FORMAT_DATE);
        $this->max_student_group = $campaign->max_student_group;
        $this->planId = $campaign->plan_id;
        $this->status = $campaign->status;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255'
            ],
            'max_student_group' => [
                'required',
                'min:1',
                'numeric'
            ]
        ];
    }

    public function updatedStatus($value)
    {
        if ($value) {
            $this->status = CampaignStatusEnum::Active->value;
        } else {
            $this->status = CampaignStatusEnum::Inactive->value;
        }
    }

    public function updatedMaxStudentGroup($value)
    {
        $this->max_student_group = (int) $value;
    }

    public function updateStartDate($value): void
    {
        if ($value) {
            $this->resetValidation('start');
        }
        $this->start = str_replace('/', '-', $value);
    }

    public function updateEndDate($value): void
    {
        if ($value) {
            $this->resetValidation('end');
        }
        $this->end = str_replace('/', '-', $value);
    }

    public function updateOfficialEndDate($value): void
    {
        if ($value) {
            $this->resetValidation('end');
        }
        $this->official_end = str_replace('/', '-', $value);
    }

    public function updateReportDeadline($value): void
    {
        if ($value) {
            $this->resetValidation('report_deadline');
        }
        $this->report_deadline = str_replace('/', '-', $value);
    }

    public function updatePlan($id): void
    {
        $this->planId = $id;
    }

    public function submit(): RedirectResponse|Redirector|null
    {
        $campaign = Campaign::findOrFail($this->campaignId);

        Gate::authorize('update',$campaign);
        $this->validate();

        if (!$this->isLoading) {
            $this->isLoading = true;
            $this->start = str_replace('/', '-', $this->start);
            $this->end = str_replace('/', '-', $this->end);
            $this->official_end = str_replace('/', '-', $this->official_end);
            try {
                $campaign->update([
                    'name' => $this->name,
                    'start' => Carbon::make($this->start),
                    'end' => Carbon::make($this->end),
                    'official_end' => Carbon::make($this->official_end),
                    'report_deadline' => Carbon::make($this->report_deadline),
                    'max_student_group' => $this->max_student_group,
                    'plan_id' => $this->planId ?? null,
                    'status' => $this->status,
                ]);
    
                session()->flash('success', 'Chỉnh sửa thành công!');
                $this->isLoading = false;
                return redirect()->route('admin.campaigns.index');
            } catch (Exception $e) {
                $this->dispatch('alert', type: 'error', message: 'Cập nhật thất bại!');
                Log::error('Error create campaign', [
                    'method' => __METHOD__,
                    'message' => $e->getMessage(),
                ]);
            }
            $this->isLoading = false;
        }
        return null;
    }

}
