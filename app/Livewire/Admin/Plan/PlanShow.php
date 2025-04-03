<?php

namespace App\Livewire\Admin\Plan;

use Livewire\Component;
use App\Common\Constants;
use App\Models\Plan;
use App\Models\PlanDetail;

class PlanShow extends Component
{
    public int|string $planId;
    public int|string $planDetailId;

    protected $listeners = [
        'deletePlanDetail' => 'delete',
    ];

    public function render()
    {
        $planDetails = PlanDetail::with('planTemplate')
            ->where('plan_id', $this->planId)
            ->paginate(Constants::PER_PAGE_ADMIN);;
        $plan = Plan::find($this->planId);
        return view('livewire.admin.plan.plan-show', [
            'planDetails' => $planDetails,
            'plan' => $plan,
        ]);
    }

    public function mount($id)
    {
        $this->planId = $id;
    }

    public function openPlanDetailModal($id)
    {
        $this->planDetailId = $id;
        $this->dispatch('openDeleteModal');
    }

    public function delete()
    {
        PlanDetail::find($this->planDetailId)->delete();
        $this->dispatch('alert', type: 'success', message: 'Xóa thành công');
    }
}
