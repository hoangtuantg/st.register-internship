<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRoleEnum;
use App\Services\SsoService;

class CampaignPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('campaign.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, Campaign $campaign): bool
    // {
    //     return false;
    // }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('campaign.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }
        return $user->hasPermission('campaign.edit') && $campaign->faculty_id === $userData['faculty_id'];
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }
        return $user->hasPermission('campaign.delete')  && $campaign->faculty_id === $userData['faculty_id'];
    }

    /**
     * Quyền xem danh sách đợt đăng ký (CompanyCampaignPolicy)
     */
    public function viewCompanyCampaign(User $user, Campaign $campaign): bool
    {
        return $user->hasPermission('company-campaign.show');
    }
}
