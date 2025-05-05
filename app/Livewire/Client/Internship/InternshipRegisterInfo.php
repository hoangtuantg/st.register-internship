<?php

namespace App\Livewire\Client\Internship;

use Livewire\Component;
use App\Models\Campaign;
use App\Models\Group;
use App\Models\GroupStudent;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\SsoService;

class InternshipRegisterInfo extends Component
{
    public string $code = '';

    public string $topic = '';
    public string $supervisor = '';

    public bool $preview = false;

    public $studentChecked = [];

    public int $countMember;


    public int|string $campaignId;

    public array $dataStudent = [];

    protected $listeners = [
        'updateSupervisor' => 'updateSupervisor',
    ];

    public function rules(): array
    {
        return [
            'dataStudent.*.email' => [
                'required',
                'email'
            ],
            'dataStudent.*.phone' => [
                'required',
                'max:255'
            ],
            'dataStudent.*.phone_family' => [
                'required',
                'max:255'
            ],
        ];
    }

    protected $validationAttributes = [
        'dataStudent.*.email' => 'email',
        'dataStudent.*.phone' => 'số điện thoại',
        'dataStudent.*.phone_family' => 'số điện thoại phụ huynh',
        'dataStudent.*.internship_company' => 'internship_company',
    ];

    public function render()
    {
        $students = Student::query()->whereIn('code', [$this->code, ...$this->studentChecked])
            ->where('campaign_id', $this->campaignId)->get();
        $campaign = Campaign::find($this->campaignId);

        // $teachers = Teacher::query()
        //     ->where('status', \App\Enums\TeacherStatusEnum::Accept->value)
        //     ->orderBy('name')
        //     ->get();
        return view('livewire.client.internship.internship-register-info', [
            'students' => $students,
            'campaign' => $campaign,
            // 'teachers' => $teachers,
        ]);
    }

    public function mount($code = '', $campaignId = 0, $studentChecked = [])
    {
        $this->code = app(SsoService::class)->getStudentCode();
        $this->studentChecked = $studentChecked;
        $this->campaignId = $campaignId;
        $campaign = Campaign::query()->find($campaignId);
        $this->countMember = $campaign->max_student_group;
        $students = Student::query()->whereIn('code', [$this->code, ...$this->studentChecked])->where('campaign_id', $this->campaignId)->get();
        foreach ($students as $student) {
            $this->dataStudent[$student->code] = [
                'email' => $student->email,
                'phone' => $student->phone,
                'phone_family' => '',
                'internship_company' => ''
            ];
        }
    }

    public function preStep()
    {
        if ($this->countMember <= 1) {
            $this->dispatch('preStepOne')->to(InternshipRegister::class);
        } else {
            $this->dispatch('preStepTwo')->to(InternshipRegister::class);
        }
    }
}
