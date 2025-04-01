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
    ];

    protected $appends = ['role_name'];

    public function userRoles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
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

        return $this->userRoles()->whereHas('permissions', function ($query) use ($permissionCode): void {
            $query->where('code', $permissionCode);
        })->exists();
    }


    public function getRoleNameAttribute(): string
    {
        return $this->userRoles()->pluck('name')->implode(', ');
    }
}
