<?php

namespace NikitinUser\userManagementModule\lib\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role = "")
    {
        if (!auth()?->check()) {
            return response('Unauthorized.', 401);
        }

        $role = preg_replace("/[^0-9 A-Za-z]/", "", $role);
        if (empty($role)) {
            return response('Bad role.', 401);
        }

        if (!auth()->user()?->hasRole($role)) {
            return response('Unavailable.', 401);
        }

        return $next($request);
    }
}
