<?php

namespace App\Livewire\Admin\Campaign;

use Livewire\Component;
use App\Common\Constants;
use App\Models\Campaign;
use Livewire\WithPagination;
use App\Services\SsoService;

class CampaignIndex extends Component
{
    use WithPagination;

    public string|int|null $campaignId = null;
    public string $search = '';

    protected $listeners = [
        'deleteCampaign' => 'handleDeleteCampaign',
    ];

    public function render()
    {
        // dd(app(SsoService::class)->getDataUser());
        $facultyId = app(SsoService::class)->getFacultyId();

        $campaigns = Campaign::query()
        ->search($this->search)
        ->where('faculty_id', $facultyId)
        ->orderBy('created_at', 'desc')   
        ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.admin.campaign.campaign-index', [
            'campaigns' => $campaigns,
        ]);
    }

    public function openDeleteModal(int $id): void
    {
        $this->campaignId = $id;
        $this->dispatch('openDeleteModal');
    }

    public function handleDeleteCampaign(): void
    {
        Campaign::destroy($this->campaignId);
        $this->dispatch('alert', type: 'success', message: 'Xóa thành công');
    }
}
