<?php

namespace App\Livewire\Admin\CompanyCampaign;

use Livewire\Component;
use App\Common\Constants;
use App\Enums\RecruitmentStatusEnum;
use App\Models\Campaign;
use App\Models\Company;
use App\Services\SsoService;

class CompanyCampaignShow extends Component
{
    public int|string $campaignId;
    public $selectedCompanies = [];
    public $updateCompanies = [];

    protected $listeners = [
        'refresh' => '$refresh',
        'saveCompany' => 'saveCompany',
    ];

    public function mount($id)
    {
        $this->campaignId = $id;

        //Lấy các công ty đã được gán cho chiến dịch
        $this->selectedCompanies = Campaign::find($this->campaignId)
            ->companies()
            ->select('companies.id') // Chỉ định rõ cột `id` từ bảng `companies`
            ->pluck('id')
            ->toArray();

        $this->updateCompanies = $this->selectedCompanies;
    }

    public function toggleCompany($companyId)
    {
        if (in_array($companyId, $this->updateCompanies)) {
            $this->updateCompanies = array_diff($this->updateCompanies, [$companyId]);
        } else {
            $this->updateCompanies[] = $companyId;
        }
    }

    public function openConfirmModal()
    {
        $this->dispatch('open-confirm-modal');
    }

    public function saveCompany()
    {
        // Lấy chiến dịch hiện tại
        $campaign = Campaign::find($this->campaignId);

        if (!$campaign) {
            session()->flash('error', 'Không tìm thấy đợt đăng ký.');
            return;
        }

        // Xác định các công ty cần thêm và cần xóa
        $companiesToAdd = array_diff($this->updateCompanies, $this->selectedCompanies);
        $companiesToRemove = array_diff($this->selectedCompanies, $this->updateCompanies);

        // Thêm các công ty mới vào bảng pivot
        foreach ($companiesToAdd as $companyId) {
            $campaign->companies()->attach($companyId, [
                'amount' => 0,
                'job_description' => '',
            ]);
        }

        // Gỡ liên kết các công ty bị loại bỏ
        foreach ($companiesToRemove as $companyId) {
            $campaign->companies()->detach($companyId);
        }

        // Cập nhật danh sách đã chọn
        $this->selectedCompanies = $this->updateCompanies;

        // Gửi thông báo thành công
        $this->dispatch('alert', type: 'success', message: 'Thay đổi đã được lưu thành công!');
    }

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();
        $campaign = Campaign::find($this->campaignId);
        $companies = Company::query()
            ->where('status', RecruitmentStatusEnum::Open)
            ->where('faculty_id', $facultyId)
            ->get();
        return view('livewire.admin.company-campaign.company-campaign-show', [
            'campaign' => $campaign,
            'companies' => $companies,
        ]);
    }

    public $selectedCompany = null;
    public function showCompanyDetail($companyId): void
    {
        $campaign = Campaign::with(['companies' => function ($query) use ($companyId) {
            $query->where('companies.id', $companyId);
        }])->find($this->campaignId);
    
        $this->selectedCompany = $campaign?->companies?->first();
    }
    
}
