<?php

namespace App\Livewire\Client\Modal;

use Livewire\Component;
use App\Models\Teacher;
use App\Services\SSOService;

class TeacherModal extends Component
{
    public $teachers;

    public function mount(SSOService $ssoService)
    {
        $studentFacultyId = app(SsoService::class)->getFacultyId(); 
        $this->teachers = Teacher::where('faculty_id', $studentFacultyId)->get();
    }

    public function render()
    {
        return view('livewire.client.modal.teacher-modal', [
            'teachers' => $this->teachers,
        ]);
    }
}
