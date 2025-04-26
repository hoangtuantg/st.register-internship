<?php

namespace App\Livewire\Admin\Student;

use App\Imports\StudentCourseImport;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class StudentImport extends Component
{
    use WithFileUploads;

    public $file;
    public string|int $campaignId;

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'mimes:xlsx,xls',
            ],

        ];
    }

    public function render()
    {
        return view('livewire.admin.student.student-import');
    }

    public function closeImportModal()
    {
        $this->dispatch('close-import-modal');
    }

    public function submit()
    {
        $this->validate();

        try {
            Excel::import(new StudentCourseImport($this->campaignId), $this->file);
            $this->dispatch('alert', type: 'success', message: 'Import thành công!');
            $this->closeImportModal();
            $this->dispatch('refresh-student');
        }catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: 'Import thất bại!');
        }
    }
}
