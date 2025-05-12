<?php

namespace App\Livewire\Client\Campaign;

use Livewire\Component;
use App\Models\Campaign;
use App\Services\SsoService;
use App\Models\Student;

class CampaignIndex extends Component
{
    public $campaigns = [];

    public function mount()
    {
        $studentCode = app(SsoService::class)->getStudentCode();

        $campaignIds = Student::where('code', $studentCode)->pluck('campaign_id');

        $this->campaigns = Campaign::whereIn('id', $campaignIds)->get();
    }

    public function goToCampaign($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);

        if ($campaign->isExpired()) {
            return redirect()->route('internship.research', $campaign->id);
        }

        return redirect()->route('internship.register', $campaign->id);
    }

    public function render()
    {
        return view('livewire.client.campaign.campaign-index');
    }
}
