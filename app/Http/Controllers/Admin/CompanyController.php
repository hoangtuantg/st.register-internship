<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        return view('pages.admin.company.index');
    }

    public function create()
    {
        return view('pages.admin.company.create');
    }

    public function edit(Company $company)
    {
        return view('pages.admin.company.edit')->with([
            'id' => $company->id,
        ]);
    }

    public function companyCampaignIndex()
    {
        return view('pages.admin.company-campaign.index');
    }

    public function companyCampaignShow(Campaign $campaign)
    {
        return view('pages.admin.company-campaign.show')->with([
            'id' => $campaign->id,
        ]);
    }

    public function companyCampaignEdit(Campaign $campaign, Company $company)
    {
        return view('pages.admin.company-campaign.edit')->with([
            'companyId' => $company->id,
            'campaignId' => $campaign->id,
        ]);
    }    
}
