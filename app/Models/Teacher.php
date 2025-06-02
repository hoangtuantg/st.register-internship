<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'status',
        'faculty_id',
        'user_id',
        'code',
        'name',
        'email',
    ];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query;
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'teacher_id');
    }
}
