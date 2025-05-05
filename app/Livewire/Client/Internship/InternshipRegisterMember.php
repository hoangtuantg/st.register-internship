<?php

namespace App\Livewire\Client\Internship;

use Livewire\Component;
use App\Models\Campaign;
use App\Models\Student;
use App\Services\SsoService;
use Illuminate\Support\Facades\Log;

class InternshipRegisterMember extends Component
{
    public string $code = '';

    public $studentChecked = [];

    public int $countMember;

    public string $search = '';

    public int|string $campaignId;

    public function clickCheckBox($code)
    {
        if (in_array($code, $this->studentChecked)) {
            $this->studentChecked = array_diff($this->studentChecked, [$code]);
        } else {

            $student = Student::query()->where('code', $code)
                ->whereNotNull('group_id')
                ->where('campaign_id', $this->campaignId)
                ->first();

            if ($student) {
                $this->dispatch('alert', type: 'error', message: 'Sinh viên ' . $student->name . '-' . $student->code . 'đã đăng ký nhóm TTCN/KLTN');
                $this->dispatch('$refresh');
                return;
            }
            $this->studentChecked[] = $code;
        }
    }

    public function render()
    {
        $studentCode = app(SsoService::class)->getStudentCode();

        $student = Student::query()
            ->where('code', $this->code)
            ->with(['course', 'campaign'])
            ->where('campaign_id', $this->campaignId)
            ->first();

        $students = Student::query()
            ->search($this->search)
            ->where('code', '!=', $studentCode)
            ->where('course_id', $student->course_id)
            ->where('group_id', null)
            ->where('campaign_id', $this->campaignId)
            ->get();

        $campaign = Campaign::find($this->campaignId);
        return view(
            'livewire.client.internship.internship-register-member',
            [
                'students' => $students,
                'student' => $student,
                'campaign' => $campaign,
            ]
        );
    }

    public function mount($campaignId = 0, $studentChecked = [])
    {
        $this->studentChecked = $studentChecked;
        $this->campaignId = $campaignId;
        $campaign = Campaign::query()->find($campaignId);
        $this->countMember = $campaign->max_student_group;
        $this->code = app(SsoService::class)->getStudentCode();
    }

    public function nextStep()
    {
        $this->dispatch('nextStepThree', [
            'studentChecked' => $this->studentChecked
        ])->to(InternshipRegister::class);
    }

    public function preStep()
    {
        $this->dispatch('preStepOne')->to(InternshipRegister::class);
    }
}
