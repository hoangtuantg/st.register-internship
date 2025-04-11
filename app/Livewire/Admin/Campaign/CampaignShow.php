<?php

namespace App\Livewire\Admin\Campaign;

use Livewire\Component;
use App\Models\Campaign;

class CampaignShow extends Component
{
    public int|string $campaignId;

    public function render()
    {
        $campaign = Campaign::query()->find($this->campaignId);
        return view('livewire.admin.campaign.campaign-show', [
            'campaign' => $campaign,
        ]);
    }
    public function mount($id)
    {
        $this->campaignId = $id;
    }
}
