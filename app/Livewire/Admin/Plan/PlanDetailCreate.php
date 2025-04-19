<?php

namespace App\Livewire\Admin\Plan;

use Livewire\Component;
use App\Common\Constants;
use App\Models\Plan;
use App\Models\PlanDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;


class PlanDetailCreate extends Component
{
    public int|string $planId;

    #[Validate(as: 'ngày bắt đầu')]
    public string $start= '';

    #[Validate(as: 'ngày kết thúc')]
    public string $end = '';

    #[Validate(as: 'nội dung')]
    public string $content = '';

    public bool $isLoading = false;
    public string $planTemplateName = '';

    protected $listeners = [
        'update-start-date' => 'updateStartDate',
        'update-end-date' => 'updateEndDate',
        'contentUpdated' => 'updateContent',
    ];

    public function render()
    {
        return view('livewire.admin.plan.plan-detail-create');
    }

    public function mount($planId)
    {
        $this->planId = $planId;
        $this->planTemplateName = Plan::query()->find($planId)->name;
        $this->start = Carbon::now()->format(Constants::FORMAT_DATE);
        $this->end = Carbon::now()->format(Constants::FORMAT_DATE);
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

    public function rules(): array
    {
        return [
            'content' => [
                'required',
            ],
        ];
    }

    public function updateContent($value): void
    {
        $this->content = $value;
        $this->validateOnly('content');
    }

    public function submit(): RedirectResponse|Redirector|null
    {
        $plan = Plan::findOrFail($this->planId);
        Gate::authorize('createDetail', $plan);

        $this->validate();
        if (!$this->isLoading) {
            $this->isLoading = true;
            $this->start = str_replace('/', '-', $this->start);
            $this->end = str_replace('/', '-', $this->end);
            try {
                PlanDetail::create([
                    'plan_id' => $this->planId,
                    'start_date' => Carbon::make($this->start),
                    'end_date' => Carbon::make($this->end),
                    'content' => $this->content,
                ]);
                session()->flash('success', 'Tạo mới thành công!');
                $this->isLoading = false;
                return redirect()->route('admin.plans.show', $this->planId);
            } catch (\Exception $e) {
                $this->dispatch('alert', type: 'error', message: 'Tạo mới thất bại!');
                Log::error('Error create plan detail', [
                    'method' => __METHOD__,
                    'message' => $e->getMessage(),
                ]);
            }
        }
        $this->isLoading = false;

        return null;
    }
}
