<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Role::class);

        return view('pages.admin.role.index');
    }

    public function create()
    {
        Gate::authorize('create', Role::class);

        return view('pages.admin.role.create');
    }

    public function edit(Role $role)
    {
        Gate::authorize('update', $role);

        return view('pages.admin.role.edit', compact('role'));
    }

}
