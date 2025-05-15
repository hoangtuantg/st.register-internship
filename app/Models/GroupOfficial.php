<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GroupOfficial extends Model
{
        use HasFactory;


    protected $fillable = [
        'supervisor', 'topic', 'campaign_id', 'teacher_id', 
        'department', 'code','report_file','report_status'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function groupKey(): MorphOne
    {
        return $this->morphOne(GroupKey::class, 'groupkeyable', 'group_type', 'group_id')->orderBy('created_at', 'desc');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->whereHas('students', function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%');
            })
            ->orWhereHas('teacher', function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            })
            ->orWhereHas('teacher', function ($q) use ($search) {
                $q->where('topic', 'like', '%'.$search.'%');
            })
            ->orWhere('topic', 'like', '%' . $search . '%');
        }

        return $query;
    }

    public function captain(): HasOne
    {
        return $this->hasOne(Student::class)->whereHas('studentGroupOfficial', function ($q) {
            $q->where('is_captain', true);
        });
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
    
}
