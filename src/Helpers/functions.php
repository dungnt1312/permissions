<?php

use App\Models\User;

if (!function_exists('fn_auth')) {
    /**
     * @return User | null
     */
    function fn_auth()
    {
        return auth()->user();
    }
}
if (!function_exists('fn_has_roles')) {
    function fn_has_roles($roles)
    {
        return  fn_is_super_admin() ||fn_auth()->hasRoles($roles);
    }
}

if (!function_exists('fn_has_permission')) {
    function fn_has_permission($permission, $model = null)
    {
        return fn_auth()->hasPermission($permission, $model);
    }
}

if (!function_exists('fn_is_super_admin')) {
    function fn_is_super_admin()
    {
        return fn_auth()->isSuperAdmin;
    }
}

if (!function_exists('fn_get_permission_layout')) {
       function fn_get_permission_layout()
    {
        return config('permission.layout', 'layouts.app');
    }
}
