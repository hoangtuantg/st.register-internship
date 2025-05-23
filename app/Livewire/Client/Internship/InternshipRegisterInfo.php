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

        $facultyId = app(SsoService::class)->getFacultyId();

        $teachers = Teacher::query()
            ->where('status', \App\Enums\TeacherStatusEnum::Accept->value)
            ->where('faculty_id', $facultyId)
            ->orderBy('name')
            ->get();
        return view('livewire.client.internship.internship-register-info', [
            'students' => $students,
            'campaign' => $campaign,
            'teachers' => $teachers,
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

    public function updateSupervisor($value)
    {
        $this->supervisor = $value;
    }

    public function nextStepFinish()
    {
        $this->validate();
        DB::beginTransaction();
        try {

            $supervisorName = null;
            if ($this->supervisor !== 'none' && $this->supervisor !== '') {
                $teacher = Teacher::where('code', $this->supervisor)->first();
                if ($teacher) {
                    $supervisorName = $teacher->name;
                }
            }

            $teacher = Teacher::where('code', $this->supervisor)->first();

            $group = Group::create([
                'topic' => $this->topic,
                'supervisor' => $supervisorName,
                'campaign_id' => $this->campaignId,
            ]);
            $captainCode = app(SsoService::class)->getStudentCode();

            foreach ($this->dataStudent as $code =>  $item) {
                $student = Student::query()->where('code', $code)
                    ->where('campaign_id', $this->campaignId)
                    ->first();

                if ($student->group_id) {
                    $this->dispatch('alert', type: "error", message: "Tạo nhóm thực tập thất bại! Sinh viên " . $student . " đã có nhóm thực tập");
                    DB::rollBack();
                    throw new \Exception();
                }

                $student->group_id = $group->id;
                $student->save();

                // Kiểm tra nếu là sinh viên đang đăng nhập và tạo nhóm ->nhóm trưởng
                $isCaptain = ($code == $captainCode) ? 1 : 0;

                GroupStudent::create([
                    'email' => $item['email'],
                    'phone' => $item['phone'],
                    'phone_family' => $item['phone_family'],
                    'internship_company' => $item['internship_company'],
                    'student_id' => $student->id,
                    'is_captain' => $isCaptain
                ]);
            }
            DB::commit();
            $this->dispatch('nextSuccess')->to(InternshipRegister::class);
        } catch (\Exception $exception) {
            Log::error('create group', [
                'message' => $exception->getMessage(),
            ]);
            $this->dispatch('alert', type: "error", message: "Tạo nhóm thực tập thất bại");
            DB::rollBack();
        }
    }
}
