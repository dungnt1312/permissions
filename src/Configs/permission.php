<?php

return [
    'role_super_admin' => 'super_admin',
    'path' => [
        'package' => base_path('vendor/dungnt1312/dnt-permission/src'),
    ],

    'layout' => 'layouts.app',
    'namespace_controller' => 'App\Http\Controllers\Admin',
    // layout publish module
    'publish_path' => [
        'controller' => app_path('Http/Controllers/Admin'),
        'views' => resource_path('views/admin/'),
    ]
];
