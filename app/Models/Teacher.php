<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'status',
        'faculty_id',
        'user_id',
        'code',
        'name',
    ];
}
