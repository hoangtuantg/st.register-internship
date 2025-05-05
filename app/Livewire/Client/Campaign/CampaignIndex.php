<?php

namespace App\Livewire\Client\Campaign;

use Livewire\Component;
use App\Models\Campaign;
use App\Services\SsoService;
use App\Models\Student;

class CampaignIndex extends Component
{
    public function render()
    {
        $studentCode = app(SsoService::class)->getStudentCode();

        $campaignIds = Student::where('code', $studentCode)->pluck('campaign_id');
        
        $campaigns = Campaign::whereIn('id', $campaignIds)->get();

        return view('livewire.client.campaign.campaign-index', [
            'campaigns' => $campaigns,
        ]);
    }

    
}
