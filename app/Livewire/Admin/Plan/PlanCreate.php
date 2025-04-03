<?php

namespace App\Livewire\Admin\Plan;

use Livewire\Component;
use App\Models\Plan;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use App\Services\SsoService;

class PlanCreate extends Component
{
    #[Validate(as: 'bản mẫu kế hoạch')]
    public string $name = '';

    #[Validate(as: 'mô tả')]
    public string $description = '';

    public bool $isLoading = false;

    public function render()
    {
        return view('livewire.admin.plan.plan-create');
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
                $facultyId = app(SsoService::class)->getFacultyId();
                Plan::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'faculty_id' => $facultyId,
                ]);
                session()->flash('success', 'Tạo mới thành công!');
                $this->isLoading = false;
                return redirect()->route('admin.plans.index');
            } catch (\Exception $e) {
               $this->dispatch('alert', type: 'error', message: 'Tạo mới thất bại!');
               Log::error('Error create plan', [
                   'method' => __METHOD__,
                   'message' => $e->getMessage(),
               ]);
            }
        }
        $this->isLoading = false;

        return null;
    }
}
