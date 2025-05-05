<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(Campaign $campaign)
    {
        if ($campaign->isExpired()) {
            return redirect()->route('internship.research', $campaign->id);
        }

        return view('pages.client.register')->with(['campaignId' => $campaign->id]);
    }
}
