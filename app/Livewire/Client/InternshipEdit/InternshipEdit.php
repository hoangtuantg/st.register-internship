<?php

namespace App\Livewire\Client\InternshipEdit;

use App\Models\Campaign;
use App\Models\Group;
use App\Models\GroupKey;
use App\Models\GroupStudent;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class InternshipEdit extends Component
{
    public string $key;
    public string|int $campaignId;

    public string $topic = '';
    public string $supervisor = '';

    public array $dataStudent = [];

    public function render()
    {
        $students = Student::query()->whereIn('code', array_keys($this->dataStudent))
            ->where('campaign_id', $this->campaignId)->get();
        $campaign = Campaign::find($this->campaignId);
        return view('livewire.client.internship-edit.internship-edit', [
            'students' => $students,
            'campaign' => $campaign,
        ]);
    }

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

    public function mount($keyEdit)
    {
        $this->key = $keyEdit;
        $groupKey = GroupKey::query()
            ->where('key', $this->key)->first();
        $group = Group::query()->where('id', $groupKey->group_id)->first();
        $students = $group->students;
        $this->topic = $group->topic;
        $this->supervisor = $group->supervisor ?? '';
        $this->campaignId = $group->campaign_id;
        foreach ($students as $student) {
            $this->dataStudent[$student->code] = [
                'email' => $student->groupStudent->email ?? $student->email,
                'phone' => $student->groupStudent->phone ?? $student->phone,
                'phone_family' => $student->groupStudent->phone_family,
                'internship_company' => $student->groupStudent->internship_company
            ];
        }
    }

    public function submit()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $groupKey = GroupKey::query()->where('key', $this->key)->first();

            Group::where('id', $groupKey->group_id)->update([
                'topic' => $this->topic,
                'supervisor' => $this->supervisor,
            ]);

            foreach ($this->dataStudent as $code => $item) {
                $student = Student::query()->where('code', $code)
                    ->where('group_id', $groupKey->group_id)
                    ->first();

                GroupStudent::where('student_id', $student->id)->update([
                    'email' => $item['email'],
                    'phone' => $item['phone'],
                    'phone_family' => $item['phone_family'],
                    'internship_company' => $item['internship_company'],
                ]);
            }

            $groupKey->active = false;
            $groupKey->save();
            DB::commit();
            session()->flash('success', 'Chỉnh sửa thông tin thành công!');
            return redirect()->route('internship.research', $this->campaignId);
        } catch (\Exception $exception) {
            Log::error('create group', [
                'message' => $exception->getMessage(),
            ]);
            $this->dispatch('alert', type: "error", message: "Chỉnh sửa nhóm thực tập thất bại");
            DB::rollBack();
        }
    }
}
