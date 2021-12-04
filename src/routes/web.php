<?php

use DNT\Permission\Controllers\RoleController;
use DNT\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('permission.route_prefix')], function () {
    Route::resource('roles', RoleController::class)->middleware(config('permission.middleware.role'));
    Route::resource('permissions', Permission::class)->middleware(config('permission.middleware.permission'));
});
