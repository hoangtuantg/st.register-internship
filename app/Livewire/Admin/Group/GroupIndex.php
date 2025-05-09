<?php

namespace App\Livewire\Admin\Group;

use Livewire\Component;
use App\Common\Constants;
use App\Exports\ExportGroupStudent;
use App\Models\Group;
use App\Models\GroupStudent;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class GroupIndex extends Component
{
    use WithPagination;

    public int|string $campaignId;
    public int|string $groupId;

    public string $search = '';

    public function openDeleteModal($id): void
    {
        $this->groupId = $id;
        $this->dispatch('openDeleteModal');
    }

    protected $listeners = [
        'deleteGroup' => 'destroy',
    ];

    public function render()
    {
        $groups = Group::query()
            ->search($this->search)
            ->where('campaign_id', $this->campaignId)
            ->with(['students', 'students.groupStudent'])
            // ->with(['students', 'students.groupStudent', 'groupKey'])
            ->orderBy('created_at', 'asc')
            ->paginate(Constants::PER_PAGE, ['*'], 'groupsPage');
        $groupAll = Group::query()
            ->search($this->search)
            ->where('campaign_id', $this->campaignId)
            ->with(['students', 'students.groupStudent'])
            ->orderBy('created_at', 'asc')->get();

        $studentRegister = Student::query()
            ->whereIn('group_id', $groupAll->pluck('id')->toArray())
            ->count();

        return view('livewire.admin.group.group-index', [
            'groups' => $groups,
            'studentRegister' => $studentRegister,
        ]);
    }

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function export()
    {
        return Excel::download(new ExportGroupStudent($this->campaignId), 'kq-dang-ky-nhom-thuc-tap.xlsx');
    }

    public function destroy(): void
    {
        DB::beginTransaction();
        try {
            $studentRes = Student::query()
                ->where('group_id', $this->groupId)->get();
            GroupStudent::query()
                ->whereIn('student_id', $studentRes->pluck('id'))
                ->delete();
            Student::query()
                ->where('group_id', $this->groupId)->update(['group_id' => null]);
            Group::destroy($this->groupId);
            DB::commit();
            $this->dispatch('alert', type: 'success', message: 'Xóa thành công!');
            $this->dispatch('$refresh');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error delete gift', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
            ]);
            $this->dispatch('alert', type: 'error', message: 'Xóa thất bại!');
        }
    }
}
