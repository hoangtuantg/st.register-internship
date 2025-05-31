<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\SsoService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function __construct(private SsoService $ssoService) {}


    public function index(): View|Application|Factory|RedirectResponse
    {
        return view('pages.admin.user.index');
    }


    public function show(User $user): View|Application|Factory|RedirectResponse
    {

        $user->load('userRoles');

        $response = $this->ssoService->get('/api/users/' . $user->sso_id);

        $userData = $response['data'] ?? $user['user_data'];
        if (is_string($userData)) {
            $decoded = json_decode($userData, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $userData = $decoded;
            } else {
                $userData = []; // fallback nếu JSON lỗi
            }
        }
        return view('pages.admin.user.show', compact('user', 'userData'));
    }
}
