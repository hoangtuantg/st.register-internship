<?php

namespace App\Livewire\Admin\Report;

use Livewire\Component;
use App\Models\Campaign;
use App\Common\Constants;
use App\Services\SsoService;

class ReportIndex extends Component
{
    public string $search = '';

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();
        $campaigns = Campaign::query()
        ->search($this->search)
        ->where('faculty_id', $facultyId)   
        ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.admin.report.report-index', [
            'campaigns' => $campaigns,
        ]);
    }
}
