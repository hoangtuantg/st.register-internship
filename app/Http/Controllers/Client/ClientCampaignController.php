<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientCampaignController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.client.campaign.index');
    }
}
