<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Enums\UserType;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    //use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sso_id',
        'status',
        'full_name',
        'code',
        'access_token',
        'user_data',
        'faculty_id',
        'role',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    // protected $hidden = [
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'status' => StatusEnum::class,
        'user_data' => 'array',
        'type' => UserType::class,
    ];

    protected $appends = ['role_name'];

    public function userRoles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role')
            ->withPivot('is_super_admin');
    }

    public function hasPermission(string $permissionCode): bool
    {
        $userData = Session::get('userData');

        if (!$userData) {
            return false;
        }

        if ($userData['role'] === UserRoleEnum::SuperAdmin->value) {
            return true;
        }
        //is_super_admin_true ==> full quyền
        // if ($this->isSuperAdmin()) {
        //     return true;
        // }

        return $this->userRoles()->whereHas('permissions', function ($query) use ($permissionCode): void {
            $query->where('code', $permissionCode);
        })->exists();
    }

    // public function isSuperAdmin(): bool
    // {
    //     return $this->userRoles()->wherePivot('is_super_admin', true)->exists();
    // }


    public function getRoleNameAttribute(): string
    {
        return $this->userRoles()->pluck('name')->implode(', ');
    }

    public function isSuperAdmin(): bool
    {
        return DB::table('user_role')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('user_role.user_id', $this->id)
            ->where('roles.name', 'Super Admin')
            ->exists();
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('full_name', 'like', '%' . $search . '%');
        }

        return $query;
    }
}
