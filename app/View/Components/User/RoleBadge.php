<?php
namespace App\View\Components\User;

use App\Enums\UserRoleEnum;
use Illuminate\View\Component;

class RoleBadge extends Component
{
    public UserRoleEnum $role;

    public function __construct(string $role)
    {
        $this->role = UserRoleEnum::from($role);
    }

    public function render()
    {
        return view('components.user.role-badge');
    }

    public function getBadgeClasses(): string
    {
        return match ($this->role) {
            UserRoleEnum::SuperAdmin => 'badge bg-light border-start border-width-3 text-body rounded-start-0 border-primary',
            UserRoleEnum::Officer => 'badge bg-light border-start border-width-3 text-body rounded-start-0 border-secondary',
            UserRoleEnum::Student => 'badge bg-light border-start border-width-3 text-body rounded-start-0 border-warning',
            UserRoleEnum::Normal => 'badge bg-light border-start border-width-3 text-body rounded-start-0 border-dark',
        };
    }
}