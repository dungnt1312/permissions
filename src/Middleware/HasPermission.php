<?php

namespace DNT\Permission\Middleware;

use DNT\Permission\Models\Permission;
use Closure;
use Illuminate\Http\Request;

class HasPermission
{

    public function handle($request, Closure $next, $permission = null)
    {
        if (!fn_has_permission($permission)) {
            abort(403);
        }
        return $next($request);
    }
}
