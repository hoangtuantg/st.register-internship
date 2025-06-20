<?php

namespace App\Livewire\Admin\Topic;

use Livewire\Component;
use App\Models\Campaign;
use App\Enums\CampaignStatusEnum;
use Livewire\Attributes\Validate;
use App\Models\Topic;
use App\Services\SsoService;
use Illuminate\Support\Facades\Gate;
use App\Models\Teacher;

class TopicUpdate extends Component
{
    #[Validate(as: 'tên đề tài')]
    public string $title = '';

    #[Validate(as: 'đợt đăng ký')]
    public $campaign_id;

    #[Validate(as: 'mô tả')]
    public $description;

    public int|string $topicId;

    public $teacherId = null;

    public function mount($id): void
    {
        $this->topicId = $id;
        $topic = Topic::findOrFail($this->topicId);
        $this->title = $topic->title;
        $this->description = $topic->description;
        $this->campaign_id = $topic->campaign_id;
        $code = app(SsoService::class)->getDataUser()['code'] ?? '';

        $teacher = Teacher::where('code', $code)->first();

        if ($teacher) {
            $this->teacherId = $teacher->id;
        }
    }

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();
        $campaigns = Campaign::where('status', CampaignStatusEnum::Active)
            ->where('faculty_id', $facultyId)
            ->get();
        return view('livewire.admin.topic.topic-update', [
            'campaigns' => $campaigns,
        ]);
    }

    public function update()
    {
        $topic = Topic::findOrFail($this->topicId);
        Gate::authorize('update', $topic);
        $this->validate();

        $topic->update([
            'title' => $this->title,
            'campaign_id' => $this->campaign_id,
            'teacher_id' => $this->teacherId,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Cập nhật đề tài thành công!');
        return redirect()->route('admin.topics.index');
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'campaign_id' => 'required',
            'description' => 'max:600',
        ];
    }
}
