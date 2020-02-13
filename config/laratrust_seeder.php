<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'home-menu'=>'r',
                'home' => 'r',
            // 'users' => 'c,r,u,d',
            // 'acl' => 'c,r,u,d',
            // 'profile' => 'r,u',
            'data-menu'=>'r',
                'data' => 'c,r,u,d',
            'acl-menu'=>'r',
                'user' => 'c,r,u,d',
                'permission' => 'r',
                'role'=>'c,r,u',
        ],
        'administrator' => [
            'home-menu'=>'r',
                'home' => 'r',
            'data-menu'=>'r',
                'data' => 'c,r,u,d',
            // 'users' => 'c,r,u,d',
            // 'profile' => 'r,u'
        ],
        // 'user' => [
        //     'home-menu'=>'r',
        //         'home' => 'r',
        //     // 'profile' => 'r,u'
        // ],
        'manager'=>[
            'home-menu'=>'r',
                'home' => 'r',
            // 'data-menu'=>'r',
            //     'data' => 'c,r,u,d',
        ],
    ],
    'permission_structure' => [
        // 'cru_user' => [
        //     'profile' => 'c,r,u'
        // ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
