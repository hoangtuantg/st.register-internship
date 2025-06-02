<?php

namespace App\Livewire\Client\Modal;

use Livewire\Component;
use App\Models\Teacher;
use App\Services\SSOService;

class TeacherModal extends Component
{
    public $teachers;
    public $campaignId;

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
        $studentFacultyId = app(SsoService::class)->getFacultyId();
        $this->teachers = Teacher::where('faculty_id', $studentFacultyId)
            ->with(['topics' => function ($query) {
                $query->where('campaign_id', $this->campaignId);
            }])
            ->get();
    }

    public function render()
    {
        return view('livewire.client.modal.teacher-modal', [
            'teachers' => $this->teachers,
        ]);
    }
}
