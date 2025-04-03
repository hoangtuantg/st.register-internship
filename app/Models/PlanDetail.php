<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanDetail extends Model
{
    use HasFactory;

    protected $table = 'plan_details';

    protected $fillable = [
        'plan_id',
        'start_date',
        'end_date',
        'content',
    ];

    public function planTemplate(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function getTimeAttribute(): bool
    {
        if ($this->start_date === $this->end_date) {
            return true;
        }
        return false;
    }
}
