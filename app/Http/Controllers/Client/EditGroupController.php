<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\GroupKey;
use App\Models\GroupOfficial;
use Illuminate\Http\Request;

class EditGroupController extends Controller
{
    public function index(string $key)
    {
        $groupKey = GroupKey::query()->where('key', $key)->firstOrFail();

        $firstKey = GroupKey::query()
            ->where('group_id', $groupKey->group_id)
            ->where('active', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$firstKey && $firstKey?->key != $key) {
            abort(419);
        }

        if (!$groupKey->active) {
            abort(419);
        }

        if ($groupKey->isExpired()) {
            abort(419);
        }

        $view = 'pages.client.editgroup.edit-group';

        if ($firstKey->group_type == GroupOfficial::class) {
            $view = 'pages.client.editgroup.edit-group-official';
        }

        return view($view, [
            'key' => $key,
        ]);
    }

    public function report(string $key)
    {
        $groupKey = GroupKey::query()->where('key', $key)->firstOrFail();

        $firstKey = GroupKey::query()
            ->where('group_id', $groupKey->group_id)
            ->where('active', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$firstKey && $firstKey?->key != $key) {
            abort(419);
        }

        if (!$groupKey->active) {
            abort(419);
        }

        if ($groupKey->isExpired()) {
            abort(419);
        }

        $view = 'pages.client.report-group';

        if ($firstKey->group_type == GroupOfficial::class) {
            $view = 'pages.client.report-group';
        }

        return view($view, [
            'key' => $key,
        ]);
    }
}
