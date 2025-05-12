<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\GroupOfficial;
use Illuminate\Support\Facades\Auth;

class ResearchController extends Controller
{
    public function index(Campaign $campaign)
    {
        $groupOfficial = GroupOfficial::query()
            ->where('campaign_id', $campaign->id)->count();

        if ($groupOfficial > 0) {
            return  redirect()->route('internship.research-official', ['campaign' => $campaign]);
        }

        return view('pages.client.research', [
            'campaignId' => $campaign->id,
        ]);
    }

    public function official(Campaign $campaign)
    {
        $groupOfficial = GroupOfficial::query()
            ->where('campaign_id', $campaign->id)->count();

        if ($groupOfficial == 0) {
            return  redirect()->route('internship.research', ['campaign' => $campaign]);
        }

        return view('pages.client.research-official', [
            'campaignId' => $campaign->id,
        ]);
    }
}
