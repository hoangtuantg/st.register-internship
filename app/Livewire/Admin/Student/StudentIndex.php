<?php

namespace App\Livewire\Admin\Student;

use Livewire\Component;
use App\Common\Constants;
use App\Models\Student;
use Livewire\WithPagination;

class StudentIndex extends Component
{
    use WithPagination;
    use WithPagination;

    public int|string $campaignId;

    public string $search = '';

    protected $listeners = [
        'refresh-student' => '$refresh'
    ];

    public function render()
    {
        $students = Student::query()
            ->search($this->search)
            ->where('campaign_id', $this->campaignId)
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.admin.student.student-index', [
            'students' => $students,
        ]); 
    }

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function openImportModal()
    {
        $this->dispatch('open-import-modal');
    }
}
