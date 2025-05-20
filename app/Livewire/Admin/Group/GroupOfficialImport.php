<?php

namespace App\Livewire\Admin\Group;

use Livewire\Component;
use App\Imports\GroupStudentOfficalImport;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class GroupOfficialImport extends Component
{
    use WithFileUploads;

    public $file;

    public string|int $campaignId;

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function closeImportModal()
    {
        $this->dispatch('close-import-group-modal');
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
        return view('livewire.admin.group.group-official-import');
    }

    public function submit()
    {
        $this->validate();

        try {
            Excel::import(new GroupStudentOfficalImport($this->campaignId), $this->file);
            $this->dispatch('alert', type: 'success', message: 'Import thành công!');
            $this->closeImportModal();
            $this->dispatch('refresh-student-group');
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: 'Import thất bại!');
        }
    }
}
