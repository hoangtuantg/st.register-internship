<?php

namespace App\Livewire\Client\Modal;

use App\Models\Campaign;
use Livewire\Component;
use App\Models\Company;
use App\Models\CampaignCompany;

class CompanyModal extends Component
{
    public $campaignId;

    public function mount($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function render()
    {
        $companies = CampaignCompany::with('company')
            ->where('campaign_id', $this->campaignId)
            ->get();
        return view('livewire.client.modal.company-modal', [
            'companies' => $companies,
        ]);
    }
}
