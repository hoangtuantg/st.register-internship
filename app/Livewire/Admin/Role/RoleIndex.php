<?php

namespace App\Livewire\Admin\Role;

use Livewire\Component;
use App\Common\Constants;
use App\Models\Role;
use App\Services\SsoService;
use Livewire\Attributes\Url;

class RoleIndex extends Component
{
    public string $search = '';

    public function render()
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        $roles = Role::query()
            ->search($this->search)
            ->where('faculty_id', $facultyId)
            ->orderBy('created_at', 'desc')
            ->paginate(Constants::PER_PAGE_ADMIN);
        return view('livewire.admin.role.role-index', [
            'roles' => $roles,
        ]);
    }

    public function placeholder()
    {
        return view('components.placeholders.table-placeholder');
    }
}
