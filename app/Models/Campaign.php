<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'start',
        'end',
        'max_student_group',
        'official_end',
        'plan_id',
        'faculty_id',
        'report_deadline',
        'status',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function planTemplate(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'campaign_company')
            ->withPivot([
                'amount',
                'job_description',
            ]);
    }

    public function scopeSearch($query, $search)
    {
        // if ($search) {
        //     $query->where('name', 'like', '%' . $search . '%');
        // }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('officialGroups.students', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                });
        }

        return $query;
    }

    public function isExpired()
    {
        $now = Carbon::now()->timestamp;
        $end = Carbon::make($this->end)->endOfDay()->timestamp;
        return $end < $now;
    }

    public function isEditOfficialExpired()
    {
        if (!$this->official_end) return true;
        $now = Carbon::now()->timestamp;
        $end = Carbon::make($this->official_end)->endOfDay()->timestamp;
        return $end < $now;
    }

    public function isReportDeadlineExpired()
    {
        if (!$this->report_deadline) return true;
        $now = Carbon::now()->timestamp;
        $end = Carbon::make($this->report_deadline)->endOfDay()->timestamp;
        return $end < $now;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($campaign) {
            GroupStudent::query()
                ->whereIn('student_id', $campaign->students->pluck('id')->toArray())
                ->delete();

            Student::query()->where('campaign_id', $campaign->id)->delete();
            GroupKey::query()->whereIn('group_id', $campaign->groups->pluck('id')->toArray())->delete();
            Group::query()->where('campaign_id', $campaign->id)->delete();
        });
    }

    public function officialGroups(): HasMany
    {
        return $this->hasMany(GroupOfficial::class);
    }
}
