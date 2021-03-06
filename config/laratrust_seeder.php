<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'card-admin'=>'r',
            'home-menu'=>'r',
                'home' => 'r',
            // 'users' => 'c,r,u,d',
            // 'acl' => 'c,r,u,d',
            // 'profile' => 'r,u',
            'data-menu'=>'r',
                'data' => 'c,r,u,d',
                'activity'=>'r',
                // 'wilayah-menu'=>'r',
                //     'provinsi'=>'r',
                //     'kabupaten'=>'r',
                //     'kecamatan'=>'r',
                //     'kelurahan'=>'r',
            'acl-menu'=>'r',
                'user' => 'c,r,u,d',
                'permission' => 'r',
                'role'=>'c,r,u',
            'penjualan-menu'=>'r',
                'penjualan-barang'=>'r',
                'penjualan'=>'r',
                'chart'=>'r',
                // 'data-penjualan'=>'r',
            'peramalan-menu'=>'r',
                'peramalan'=>'r',
            // 'activity-menu'=>'r',
                
        ],
        // 'administrator' => [
        //     'card-admin'=>'r',
        //     'home-menu'=>'r',
        //         'home' => 'r',
        //     'data-menu'=>'r',
        //         'data' => 'c,r,u,d',
        //         'activity'=>'r',
        //         'wilayah-menu'=>'r',
        //             'provinsi'=>'r',
        //             'kabupaten'=>'r',
        //             'kecamatan'=>'r',
        //             'kelurahan'=>'r',
        //     'penjualan-menu'=>'r',
        //         'penjualan'=>'r',
        //         'chart'=>'r',
        //     'peramalan-menu'=>'r',
        //         'peramalan'=>'r',
            // 'activity-menu'=>'r',
                
            // 'users' => 'c,r,u,d',
            // 'profile' => 'r,u'
        // ],
        // 'user' => [
        //     'home-menu'=>'r',
        //         'home' => 'r',
        //     // 'profile' => 'r,u'
        // ],
        'manager'=>[
            'card-manager'=>'r',
            'home-menu'=>'r',
                'home' => 'r',
            'data-menu'=>'r',
                'activity'=>'r',
            'penjualan-menu'=>'r',
                'penjualan'=>'r',
                'chart'=>'r',
            'peramalan-menu'=>'r',
                'peramalan'=>'r',
            // 'activity-menu'=>'r',
            // 'data-menu'=>'r',
            //     'data' => 'c,r,u,d',
        ],
        'front_office'=>[
            'card-front'=>'r',
            'home-menu'=>'r',
                'home' => 'r',
            'penjualan-menu'=>'r',
                'penjualan-barang'=>'r',
            'data-menu'=>'r',
                'data' => 'c,r,u,d',
                'activity'=>'r',
            // 'peramalan-menu'=>'r',
            //     'peramalan'=>'r',
            // 'activity-menu'=>'r',
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
