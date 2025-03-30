<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index() 
    {
        return view('pages.admin.campaign.index');
    }
}
