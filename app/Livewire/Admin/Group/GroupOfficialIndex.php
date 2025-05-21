<?php

namespace App\Livewire\Admin\Group;

use App\Common\Constants;
use App\Exports\ExportGroupOfficialStudent;
use App\Models\GroupOfficial;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class GroupOfficialIndex extends Component
{
    use WithPagination;

    public int|string $campaignId;

    public string $search = '';

    protected $listeners = [
        'refresh-student-group' => '$refresh'
    ];

    public function render()
    {
        $groups = GroupOfficial::query()
            ->search($this->search)
            ->where('campaign_id', $this->campaignId)
            ->with(['students', 'students.studentGroupOfficial', 'teacher'])
            ->orderBy('code', 'asc')
            ->paginate(Constants::PER_PAGE, ['*'], 'groupsPageOfficial');

        $groupAll = GroupOfficial::query()
            ->search($this->search)
            ->where('campaign_id', $this->campaignId)
            ->with(['students', 'students.studentGroupOfficial', 'teacher'])
            ->orderBy('created_at', 'asc')->get();

        $studentRegister = Student::query()
            ->whereIn('group_official_id', $groupAll->pluck('id')->toArray())
            ->count();
        return view('livewire.admin.group.group-official-index', [
            'groups' => $groups,
            'studentRegister' => $studentRegister,
        ]);
    }

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function openImportGroupModal()
    {
        $this->dispatch('open-import-group-modal');
    }

    public function export()
    {
        return Excel::download(new ExportGroupOfficialStudent($this->campaignId), 'kq-chinh-thuc-nhom-thuc-tap.xlsx');
    }
}
