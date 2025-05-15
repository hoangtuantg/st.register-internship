<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

class GroupKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'key',
        'active',
        'group_type'
    ];

    public function isExpired()
    {
        $now = Carbon::now();
        $createdAt = $this->created_at;

        return $now->diffInHours($createdAt) >= 1;
    }

    public function groupkeyable(): MorphTo
    {
        return $this->morphTo();
    }
}
