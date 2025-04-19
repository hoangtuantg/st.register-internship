<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;    
use App\Models\Company;

class CompanyCampaignPolicy
{
    /**
     * Quyền xem danh sách các đợt đăng ký
     */
    // public function viewCampaignList(User $user): bool
    // {
    //     return $user->hasPermission('company-campaign.index');
    // }

    /**
     * Quyền xem danh sách công ty trong đợt đăng ký
     */
    // public function viewCompanyCampaign(User $user, Campaign $campaign): bool
    // {
    //     return $user->hasPermission('company-campaign.show');
    // }

    /**
     * Quyền cập nhật thông tin công ty trong đợt đăng ký
     */
    // public function updateCompanyCampaign(User $user, Company $company): bool
    // {
    //     return $user->hasPermission('company-campaign.update');
    // }

    /**
     * Quyền thêm hoặc xóa công ty ra khỏi đợt đăng ký
     */
    // public function modifyCompanyCampaign(User $user, Company $company): bool
    // {
    //     return $user->hasPermission('company-campaign.modify');
    // }
}
