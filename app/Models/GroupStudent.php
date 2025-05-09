<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupStudent extends Model
{
    use HasFactory;

    protected $table = 'group_students';

    protected $fillable = ['phone', 'internship_company', 'phone_family', 'email', 'student_id', 'is_captain'];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
