<?php

return [
    'role_super_admin' => 'super_admin',
    'route_prefix' => 'admin',
    'middleware' => [
        'role' => ['web', 'auth', 'roles:super_admin'],
        'permission' => ['web', 'auth', 'roles:super_admin']
    ]
];
