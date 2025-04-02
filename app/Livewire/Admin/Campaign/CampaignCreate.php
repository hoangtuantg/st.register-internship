<?php

namespace App\Livewire\Admin\Campaign;

use Livewire\Component;

use App\Common\Constants;
use App\Enums\CampaignStatusEnum;
use App\Models\Campaign;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CampaignCreate extends Component
{
    #[Validate(as: 'tên đợt chiến dịch')]
    public string $name = '';

    #[Validate('required', as: 'ngày bắt đầu')]
    public string $start = '';

    #[Validate('required', as: 'ngày kết thúc')]
    public string $end = '';

    #[Validate(as: 'số lượng thành viên trong nhóm')]
    public int $max_student_group = 0;

    public int|string $planId;
    public bool $isLoading = false;

    protected $listeners = [
        'update-start-date' => 'updateStartDate',
        'update-end-date' => 'updateEndDate',
        'selectedPlan' => 'updatePlan'
    ];

    public function mount(): void
    {
        $this->start = Carbon::now()->format(Constants::FORMAT_DATE);
        $this->end = Carbon::now()->format(Constants::FORMAT_DATE);
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

    // public function updatePlan($id): void
    // {
    //     $this->planId = $id;
    // }

    public function submit()
    {
        $this->validate();

        if (!$this->isLoading) {
            $this->isLoading = true;
            $this->start = str_replace('/', '-', $this->start);
            $this->end = str_replace('/', '-', $this->end);
            try {
                $user = Auth::user();
                $userRole = DB::table('user_role')
                ->where('user_id', $user->id)
                ->first();
                if ($userRole) {
                    $role = DB::table('roles')->find($userRole->role_id);
                    $faculty_id = $role ? $role->faculty_id : null;
                } else {
                    $faculty_id = null;
                }
                Campaign::create([
                    'name' => $this->name,
                    'start' => Carbon::make($this->start),
                    'end' => Carbon::make($this->end),
                    'max_student_group' => $this->max_student_group,
                    // 'plan_template_id' => $this->planId ?? null,
                    'status' => CampaignStatusEnum::Active->value,
                    'faculty_id' => $faculty_id,
                ]);
                session()->flash('success', 'Tạo mới thành công!');
                $this->isLoading = false;
                return redirect()->route('admin.campaigns.index');
            } catch (Exception $e) {
                $this->dispatch('alert', type: 'error', message: 'Tạo mới thất bại!');
                Log::error('Error create campaign', [
                    'method' => __METHOD__,
                    'message' => $e->getMessage(),
                ]);
            }
            $this->isLoading = false;
        }
        return null;
    }

    // public function render()
    // {
    //     $planTemplates = Plan::all();
    //     return view('livewire.admin.campaign.campaign-create')->with([
    //         'planTemplates' => $planTemplates
    //     ]);
    // }
}
