<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentGroupOfficial extends Model
{
    protected $table = 'student_group_officials';

    protected $fillable = [
        'phone',
        'internship_company',
        'phone_family',
        'email',
        'student_id',
        'supervisor_company',
        'supervisor_company_email',
        'supervisor_company_phone',
        'is_captain'
    ];

    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
