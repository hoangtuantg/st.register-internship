<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    public function index()
    {
        return view('pages.admin.topic.index');
    }

    public function create()
    {
        return view('pages.admin.topic.create');
    }

    public function edit(Topic $topic)
    {
        return view('pages.admin.topic.edit')->with([
            'id' => $topic->id,
        ]);
    }
}
