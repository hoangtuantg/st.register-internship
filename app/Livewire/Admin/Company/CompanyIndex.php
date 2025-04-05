<?php

namespace App\Livewire\Admin\Company;

use Livewire\Component;
use App\Models\Company;
use App\Common\Constants;
use Livewire\WithPagination;
use App\Services\SsoService;
use App\Enums\RecruitmentStatusEnum;

class CompanyIndex extends Component
{
    public $search;
    public $companyId;
    use WithPagination;

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();
        $companies = Company::query()
        ->search($this->search)
        ->where('faculty_id', $facultyId)
        ->orderBy('created_at', 'desc')
        ->paginate(Constants::PER_PAGE, ['*'], 'groupsPageOfficial');
        return view('livewire.admin.company.company-index', [
            'companies' => $companies,
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage('groupsPageOfficial');
    }

    public function openDeleteModal($id): void
    {
        $this->companyId = $id;
        $this->dispatch('openDeleteModal');
    }

    protected $listeners = [
        'deleteCompany' => 'destroy',
    ];

    public function destroy(): void
    {
        Company::destroy($this->companyId);
        $this->dispatch('alert', type: 'success', message: 'Xóa thành công');
    }
    
    public $selectedCompany = null;
    public function showCompanyDetail($id): void
    {
        $this->selectedCompany = Company::find($id);
    }

    public function openRecruitment($companyId): void
    {
        $company = Company::find($companyId);
        if ($company) {
            $company->status = RecruitmentStatusEnum::Open->value;
            $company->save();
        }
    }

    public function cancelRecruitment($companyId): void
    {
        $company = Company::find($companyId);
        if ($company) {
            $company->status = RecruitmentStatusEnum::Closed->value;
            $company->save();
        }
    }
}
