<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanDetail;
use Illuminate\Http\Request;


class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('planDetails')->get();
        return view('pages.admin.plan.index', compact('plans'));
    }

    public function create()
    {
        return view('pages.admin.plan.create');
    }

    public function edit(Plan $plan)
    {
        return view('pages.admin.plan.edit')->with([
            'id' => $plan->id,
        ]);
    }

    public function show(Plan $plan)
    {
        return view('pages.admin.plan.show')->with([
            'id' => $plan->id,
        ]);
    }

    public function editPlanDetail(PlanDetail $planDetail)
    {
        $planTemplateId = $planDetail->planTemplate->id;
        return view('pages.admin.plan.detail-edit')->with([
            'id' => $planDetail->id,
            'planTemplateId' => $planTemplateId,
        ]);
    }

    public function createPlanDetail(Plan $plan)
    {
        return view('pages.admin.plan.detail-create')->with([
            'id' => $plan->id,
        ]);
    }
}
