<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\Plan;
use App\Models\User;
use App\Services\SsoService;

class PlanPolicy
{
    /**
     * Xem danh sách Plan
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('plan.index');
    }

    /**
     * Xem chi tiết 1 Plan
     */
    public function view(User $user, Plan $plan): bool
    {
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }

        return $user->hasPermission('plan.index') && $plan->faculty_id === $userData['faculty_id'];
    }

    /**
     * Tạo mới Plan
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('plan.create');
    }

    /**
     * Cập nhật Plan
     */
    public function update(User $user, Plan $plan): bool
    {
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }

        return $user->hasPermission('plan.edit') && $plan->faculty_id === $userData['faculty_id'];
    }

    /**
     * Xóa Plan
     */
    public function delete(User $user, Plan $plan): bool
    {
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }
        return $user->hasPermission('plan.delete') && $plan->faculty_id === $userData['faculty_id'];
    } 


    /**
     * Quyền thêm chi tiết kế hoạch
     */
    public function createDetail(User $user, Plan $plan): bool
    {
        // return $this->view($user, $plan);
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }
        return $user->hasPermission('plan.createDetail') && $plan->faculty_id === $userData['faculty_id'];
    }

    /**
     * Quyền sửa chi tiết kế hoạch
     */
    public function editDetail(User $user, Plan $plan): bool
    {
        // return $this->view($user, $plan);
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }
        return $user->hasPermission('plan.editDetail') && $plan->faculty_id === $userData['faculty_id'];
    }

    /**
     * Quyền xoá chi tiết kế hoạch
     */
    public function deleteDetail(User $user, Plan $plan): bool
    {
        // return $this->view($user, $plan);
        $userData = app(SsoService::class)->getDataUser();

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }
        return $user->hasPermission('plan.deleteDetail') && $plan->faculty_id === $userData['faculty_id'];
    }
}
