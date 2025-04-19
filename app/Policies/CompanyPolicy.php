<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Models\Company;
use App\Services\SsoService;

class CompanyPolicy
{
    /**
     * Quyền xem danh sách companies
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('company.index');
    }

    /**
     * Quyền tạo mới
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('company.create');
    }

    /**
     * Quyền cập nhật
     */
    public function update(User $user, Company $company): bool
    {
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }

        return $user->hasPermission('company.edit') && $company->faculty_id === $userData['faculty_id'];
    }

    public function delete(User $user, Company $company): bool
    {
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }
        return $user->hasPermission('company.delete') && $company->faculty_id === $userData['faculty_id'];
    }

    /**
     * Quyền cập nhật thông tin công ty trong đợt đăng ký(CompanyCampaignPolicy)
     */
    public function updateCompanyCampaign(User $user, Company $company): bool
    {
        return $user->hasPermission('company-campaign.update');
    }

    /**
     * Quyền thêm hoặc xóa công ty ra khỏi đợt đăng ký(CompanyCampaignPolicy)
     */
    public function modifyCompanyCampaign(User $user): bool
    {
        return $user->hasPermission('company-campaign.modify');
    }
}
