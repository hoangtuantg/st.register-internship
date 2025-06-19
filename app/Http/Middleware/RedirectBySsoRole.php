<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\SsoService;
use App\Enums\UserRoleEnum;

class RedirectBySsoRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userData = app(SsoService::class)->getDataUser();
        $role = $userData['role'];
        $path = $request->path();

        //Nếu là admin (super_admin, officer) mà vào route không phải admin
        if (
            in_array($role, [UserRoleEnum::SuperAdmin->value, UserRoleEnum::Officer->value])
            && !$request->is('admin/*') && $path !== 'admin'
        ) {
            return redirect('/admin');
        }

        //Nếu là student mà vào route admin
        if (
            $role === UserRoleEnum::Student->value
            && ($request->is('admin/*') || $path === 'admin')
        ) {
            return redirect('/');
        }

        return $next($request);
    }
}
