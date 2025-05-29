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

class TopicCreate extends Component
{
    public $teacherId = null;

    #[Validate(as: 'tên đề tài')]
    public string $title = '';

    #[Validate(as: 'đợt đăng ký')]
    public $campaign_id;

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();
        $campaigns = Campaign::where('status', CampaignStatusEnum::Active)
            ->where('faculty_id', $facultyId)
            ->get();
        return view('livewire.admin.topic.topic-create', [
            'campaigns' => $campaigns,
        ]);
    }

    public function store()
    {
        Gate::authorize('create', Topic::class);

        $this->validate();

        // Lấy mã người dùng đăng nhập từ SSO
        $code = app(SsoService::class)->getDataUser()['code'] ?? '';

        // Tìm giảng viên theo mã
        $teacher = Teacher::where('code', $code)->first();

        // Nếu không tìm thấy thì không hiển thị nhóm nào cả
        if ($teacher) {
            $this->teacherId = $teacher->id;
        }

        Topic::create([
            'title' => $this->title,
            'campaign_id' => $this->campaign_id,
            'teacher_id' => $this->teacherId,
        ]);

        session()->flash('success', 'Tạo chủ đề thành công!');
        return redirect()->route('admin.topics.index');
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'campaign_id' => 'required',
        ];
    }
}
