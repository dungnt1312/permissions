<?php

namespace DNT\Permission\Middleware;

use DNT\Permission\Models\Permission;
use Closure;
use Illuminate\Http\Request;

class HasRoles
{

    public function handle($request, Closure $next, $roles = null)
    {
        $roles = !empty($roles) ? explode(',', $roles) : [];
        if (!fn_has_roles($roles)) {
            abort(403);
        }
        return $next($request);
    }
}
