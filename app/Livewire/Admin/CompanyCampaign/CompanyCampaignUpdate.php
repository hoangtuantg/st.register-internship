<?php

namespace App\Livewire\Admin\CompanyCampaign;

use Livewire\Component;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyCampaignUpdate extends Component
{
    public $companyId;
    public $campaignId;
    public $amount;
    public $jobDescription;

    public function mount($companyId, $campaignId)
    {
        $this->companyId = $companyId;
        $this->campaignId = $campaignId;

        $company = DB::table('campaign_company')
            ->where('company_id', $this->companyId)
            ->where('campaign_id', $this->campaignId)
            ->first();

        $this->amount = $company->amount;
        $this->jobDescription = $company->job_description;
    }

    public function render()
    {
        $company = Company::find($this->companyId);
        return view('livewire.admin.company-campaign.company-campaign-update', [
            'company' => $company,
        ]);
    }

    public function update()
    {
        DB::table('campaign_company')
            ->where('company_id', $this->companyId)
            ->update([
                'amount' => $this->amount,
                'job_description' => $this->jobDescription,
            ]);

        $this->dispatch('alert', type: 'success', message: 'Cập nhật thành công! Hãy bấm tải lại dữ liệu');
    }
}
