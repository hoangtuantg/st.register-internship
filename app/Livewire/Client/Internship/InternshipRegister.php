<?php

namespace App\Livewire\Client\Internship;

use Livewire\Component;
use App\Enums\StepRegisterEnum;
use App\Models\Campaign;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use App\Models\Teacher;
use App\Models\Company;
use App\Services\SsoService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;



class InternshipRegister extends Component
{
    public StepRegisterEnum $step = StepRegisterEnum::StepOne;

    public int|string $campaignId;

    public array $studentChecked = [];

    public string $code = '';

    protected $listeners = [
        'nextStepThree' => 'nextStepThree',
        'nextSuccess' => 'nextSuccess',
        'preStepOne' => 'preStepOne',
        'preStepTwo' => 'preStepTwo',
    ];

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
        $this->code = app(SsoService::class)->getStudentCode();

        //redirect nếu sinh viên đã có nhóm
        $student = Student::where('code', $this->code)
            ->where('campaign_id', $campaignId)
            ->first();

        if ($student->group_id) {
            return redirect()->route('internship.research', $campaignId);
        }
    }

    public function render()
    {
        $campaign = Campaign::query()
            ->where('id', $this->campaignId)
            ->first();
        return view(
            'livewire.client.internship.internship-register',
            [
                'campaign' => $campaign,
            ]
        );
    }

    public function nextStepThree($data)
    {
        $this->studentChecked = $data['studentChecked'];
        $this->step = StepRegisterEnum::StepThree;
    }

    // public function nextStepThree($data = [])
    // {
    //     Log::info('nextStepThree called with data: ' . json_encode($data));
    //     $this->studentChecked = $data['studentChecked'] ?? [];
    //     $this->step = StepRegisterEnum::StepThree;
    //     Log::info('Updated studentChecked: ' . json_encode($this->studentChecked));
    //     Log::info('Step changed to: ' . $this->step->value);
    //     $this->dispatch('$refresh');
    // }

    public function preStepOne()
    {
        $this->step = StepRegisterEnum::StepOne;
        $this->studentChecked = [];
    }

    public function preStepTwo()
    {
        $this->step = StepRegisterEnum::StepTwo;
    }

    public function nextStepTwo()
    {

        $student = Student::query()
            ->where('code', $this->code)
            ->where('campaign_id', $this->campaignId)
            ->with('campaign')
            ->first();

        if (! $student) {
            $this->dispatch('alert', type: 'error', message: 'Sinh viên không tồn tại hoặc không nằm trong danh sách đủ điều kiện làm TTCN hoặc KLTN');
            return;
        }

        if ($student->group_id) {
            $this->dispatch('alert', type: 'error', message: 'Bạn đã có nhóm thực tập! Vui lòng tra cứu thông tin nhóm tại mục tra cứu');

            return;
        }

        if ($student->campaign->isExpired()) {
            $this->dispatch('alert', type: 'error', message: 'Đã hết thời hạn đăng ký');
            return;
        }

        if ($student->campaign->max_student_group === 1) {
            $this->step = StepRegisterEnum::StepThree;
        } else {
            $this->step = StepRegisterEnum::StepTwo;
        }
    }
}
