<?php

namespace App\Exports;

use App\Models\GroupOfficial;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportGroupOfficialStudent implements FromView
{
    public function __construct(private $campaignId)
    {
    }

    public function view(): View
    {
        return view('exports.group-official-student', [
            'groups' => GroupOfficial::query()
                ->where('campaign_id', $this->campaignId)
                ->with(['students', 'students.studentGroupOfficial', 'teacher'])
                ->orderBy('code')
                ->get()
        ]);
    }
}
