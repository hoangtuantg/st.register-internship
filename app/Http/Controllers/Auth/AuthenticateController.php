<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Services\SsoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Throwable;
use App\Enums\StatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Role;
use Illuminate\Support\Facades\DB;


class AuthenticateController extends Controller
{
    public function redirectToSSO()
    {
        $query = http_build_query([
            'client_id' => config('auth.sso.client_id'),
            'redirect_uri' => route('sso.callback'),
            'response_type' => 'code',
            'scope' => '',
        ]);

        return redirect(config('auth.sso.uri') . '/oauth/authorize?' . $query);
    }

    public function handleCallback(Request $request)
    {
        try {
            $data = $this->getAccessToken($request->code);
            if (! isset($data['access_token'])) {
                return abort(401);
            }

            Session::put('access_token', $data['access_token']);

            $userData = $this->getUserData($data['access_token']);
            $user = $this->findOrCreateUser($userData);
            $this->storeSessionData($userData);
            Auth::login($user);
            if ($userData['role'] === UserRoleEnum::SuperAdmin->value && empty($userData['faculty_id'])) {
                return redirect()->route('faculty.select');
            }
            return redirect()->route('admin.campaigns.index');
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return abort(401);
        }
    }

    public function logout()
    {
        app(SsoService::class)->clearAuth();

        return redirect(config('auth.sso.uri'));
    }

    private function getAccessToken(string $code): array
    {
        $response = Http::asForm()->post(config('auth.sso.uri') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('auth.sso.client_id'),
            'client_secret' => config('auth.sso.client_secret'),
            'redirect_uri' => route('sso.callback'),
            'code' => $code,
        ]);

        return $response->json();
    }

    private function getUserData(string $accessToken): array
    {
        $response = Http::withToken($accessToken)->get(config('auth.sso.uri') . '/api/user');

        return $response->json();
    }

    private function findOrCreateUser(array $userData): User
    {
        $user =  User::firstOrCreate(
            ['sso_id' => $userData['id']],
            ['status' => StatusEnum::Active]
        );

        // if ($user['role'] === UserRoleEnum::Student->value) {
        //     Student::updateOrCreate([
        //         'code' => $userData['code'],
        //         'email' => $userData['email']
        //     ], [
        //         'user_id' => $user->id,
        //         'first_name' => $userData['first_name'],
        //         'last_name' => $userData['last_name'],
        //         'email' => $userData['email'],
        //         'phone' => $userData['phone'],
        //         'code' => $userData['code']
        //     ]);
        // }

        // if (!empty($userData['faculty_id'])) {
        //     try {
        //         // Cách 1: Sử dụng pluck với tên cột đầy đủ
        //         $roleIds = $user->userRoles()->pluck('roles.id')->toArray();
                
        //         Role::whereIn('id', $roleIds)
        //             ->update(['faculty_id' => $userData['faculty_id']]);
        //     } catch (\Exception $e) {
        //         Log::error('Error updating faculty_id: ' . $e->getMessage());
        //     }
        // }

        if (
            (User::count() === 1 && $userData['role'] === UserRoleEnum::Officer->value) ||
            ($userData['role'] === UserRoleEnum::SuperAdmin->value)
        ) {
            $superAdminRole = Role::firstOrCreate(
                ['name' => 'Super Admin'],
            );
            // DB::table('user_role')->updateOrInsert(
            //     ['is_super_admin' => true]
            // );
            // if (!$user->userRoles()->where('role_id', $superAdminRole->id)->exists()) {
            //     $user->userRoles()->attach($superAdminRole->id);
            // }
            if (!$user->userRoles()->where('role_id', $superAdminRole->id)->exists()) {
                // Gán role + is_super_admin = true qua bảng trung gian
                $user->userRoles()->attach($superAdminRole->id, ['is_super_admin' => true]);
            } else {
                // Đảm bảo cập nhật lại cờ is_super_admin nếu đã tồn tại role
                $user->userRoles()->updateExistingPivot($superAdminRole->id, ['is_super_admin' => true]);
            }
        }
        
        return $user;
    }

    private function storeSessionData(array $userData): void
    {
        Session::put('userData', $userData);
        if ($userData['role'] !== UserRoleEnum::SuperAdmin->value && empty($userData['faculty_id'])) {
            abort(403);
        }
        if ($userData['role'] !== UserRoleEnum::SuperAdmin->value) {
            Session::put('faculty_id', $userData['faculty_id']);
        }
    }
}
