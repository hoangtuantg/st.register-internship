<?php

namespace App\Livewire\Admin\Plan;

use App\Models\Plan;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PlanUpdate extends Component
{
    public int|string $planId;

    #[Validate(as: 'bản mẫu kế hoạch')]
    public string $name = '';

    #[Validate(as: 'mô tả')]
    public string $description = '';

    public bool $isLoading = false;

    public function render()
    {
        return view('livewire.admin.plan.plan-update');
    }

    public function mount($id)
    {
        $this->planId = $id;
        $plan = Plan::find($this->planId);
        $this->name = $plan->name;
        $this->description = $plan->description;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    public function submit()
    {
        $this->validate();

        if (!$this->isLoading) {
            $this->isLoading = true;

            try {
                Plan::find($this->planId)->update([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);
                session()->flash('success', 'Cập nhật thành công!');
                $this->isLoading = false;
                return redirect()->route('admin.plans.index');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'error',
                    'message' => 'Cập nhật thất bại!',
                ]);
            }
        }
        $this->isLoading = false;
    }
}
