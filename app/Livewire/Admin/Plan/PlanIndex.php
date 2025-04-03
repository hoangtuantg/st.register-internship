<?php

namespace App\Livewire\Admin\Plan;

use Livewire\Component;
use App\Common\Constants;
use App\Models\Plan;
use App\Models\PlanDetail;
use App\Services\SsoService;

class PlanIndex extends Component
{
    public string $search = '';
    public int|string $planId;

    protected $listeners = [
        'deletePlan' => 'delete',
    ];

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();
        $plans = Plan::query()
        ->search($this->search)
        ->where('faculty_id', $facultyId)
        ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.admin.plan.plan-index', [
            'plans' => $plans,
        ]);
    }

    public function openDeleteModal($id)
    {
        $this->planId = $id;
        $this->dispatch('openDeleteModal');
    }

    public function delete()
    {
        Plan::find($this->planId)->delete();
        $this->dispatch('alert', type: 'success', message: 'Xóa thành công');
    }

    public function copy($id)
    {
        $plan = Plan::find($id);
        if ($plan) {
            $newPlan = $plan->replicate();
            $newPlan->name = $plan->name . ' - Bản sao';
            $newPlan->save();

            $planDetails = PlanDetail::where('plan_id', $plan->id)->get();
            foreach ($planDetails as $detail) {
                $newDetail = $detail->replicate();
                $newDetail->plan_id = $newPlan->id;
                $newDetail->save();
            }
            $this->dispatch('alert', type: 'success', message : 'Sao chép thành công');
        }
    }
}
