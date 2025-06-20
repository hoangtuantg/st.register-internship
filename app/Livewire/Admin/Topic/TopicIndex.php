<?php

namespace App\Livewire\Admin\Topic;

use Livewire\Component;
use App\Models\Topic;
use App\Models\Teacher;
use Livewire\WithPagination;
use App\Common\Constants;
use App\Services\SsoService;

class TopicIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public int $topicId;

    public $teacherId = null;


    protected $listeners = [
        'deleteTopic' => 'handleDeleteTopic',
    ];

    public function mount() {}
    public function render()
    {
        // Lấy mã người dùng đăng nhập từ SSO
        $code = app(SsoService::class)->getDataUser()['code'] ?? '';

        // Tìm giảng viên theo mã
        $teacher = Teacher::where('code', $code)->first();

        // Nếu không tìm thấy thì không hiển thị nhóm nào cả
        if ($teacher) {
            $this->teacherId = $teacher->id;
        }

        $topics = Topic::where('teacher_id', $this->teacherId)
            ->search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.admin.topic.topic-index', [
            'topics' => $topics,
        ]);
    }

    public function openDeleteModal(int $id): void
    {
        $this->topicId = $id;
        $this->dispatch('openDeleteModal');
    }

    public function handleDeleteTopic(): void
    {
        Topic::destroy($this->topicId);
        $this->dispatch('alert', type: 'success', message: 'Xóa thành công');
    }

    public $selectedTopic = null;

    public function topicDetail($id): void
    {
        $this->selectedTopic = Topic::find($id);
    }

    public function copy($id)
    {
        $original = Topic::find($id);

        if (!$original) {
            $this->dispatch('alert', type: 'error', message: 'Không tìm thấy đề tài.');
            return;
        }

        // Gửi dữ liệu sang component tạo mới
        session()->flash('copied_title', $original->title);
        session()->flash('copied_description', $original->description);

        // Redirect sang route tạo đề tài
        return redirect()->route('admin.topics.create');
    }
}
