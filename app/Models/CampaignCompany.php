<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignCompany extends Model
{
    protected $table = 'campaign_company'; 

    protected $fillable = [
        'campaign_id',
        'company_id',
        'job_description',
        'amount',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
