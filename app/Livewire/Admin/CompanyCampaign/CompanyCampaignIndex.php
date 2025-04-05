<?php

namespace App\Livewire\Admin\CompanyCampaign;

use Livewire\Component;
use App\Models\Campaign;
use App\Common\Constants;
use App\Services\SsoService;


class CompanyCampaignIndex extends Component
{
    public string $search = '';
    
    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();
        $campaigns = Campaign::query()
        ->search($this->search)
        ->where('faculty_id', $facultyId)
        ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.admin.company-campaign.company-campaign-index', [
            'campaigns' => $campaigns,
        ]);
    }
}
