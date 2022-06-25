<?php

namespace NikitinUser\userManagementModule\lib\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission = "")
    {
        if (!auth()?->check()) {
            return response('Unauthorized.', 401);
        }

        $permission = preg_replace("/[^0-9 A-Za-z]/", "", $permission);
        if (empty($permission)) {
            return response('Bad permission.', 401);
        }

        if (!auth()->user()?->hasPermission($permission)) {
            return response('Unavailable.', 401);
        }

        return $next($request);
    }
}
