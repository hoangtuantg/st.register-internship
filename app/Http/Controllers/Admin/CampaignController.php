<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index() 
    {
        return view('pages.admin.campaign.index');
    }

    public function create()
    {
        return view('pages.admin.campaign.create');
    }


    public function edit(Campaign $campaign)
    {
        return view('pages.admin.campaign.edit')->with([
            'id' => $campaign->id,
        ]);
    }

    public function show(Campaign $campaign)
    {
        return view('pages.admin.campaign.show')->with([
            'id' => $campaign->id,
        ]);
    }

    // public function downloadTemplateStudent()
    // {
    //     $filePath = public_path('templates/student.xlsx');
    //     return response()->download($filePath);
    // }

    // public function downloadTemplateStudentGroup()
    // {
    //     $filePath = public_path('templates/student-group.xlsx');
    //     return response()->download($filePath);
    // }
}
