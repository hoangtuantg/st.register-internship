<?php

namespace App\Exports;

use App\Models\Group;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportGroupStudent implements FromView
{
    public function __construct(private $campaignId)
    {
    }

    public function view(): View
    {
        return view('exports.group-student', [
            'groups' => Group::query()
                ->where('campaign_id', $this->campaignId)
                ->with(['students', 'students.groupStudent'])
                ->orderBy('created_at')
                ->get()
        ]);
    }
}
