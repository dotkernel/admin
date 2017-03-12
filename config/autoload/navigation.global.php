<?php

return [
    'dot_navigation' => [

        //enable menu item active if any child is active
        'active_recursion' => true,

        'containers' => [
            'main_menu' => [
                'type' => 'ArrayProvider',
                'options' => [
                    'items' => [
                        [
                            'options' => [
                                'label' => 'Dashboard',
                                'route' => 'dashboard',
                                'params' => ['action' => ''],
                                'icon' => 'fa fa-tachometer',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Manage admins',
                                'route' => 'user',
                                'params' => ['action' => 'manage'],
                                'icon' => 'fa fa-user-circle-o',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Manage users',
                                'route' => 'f_user',
                                'params' => ['action' => 'manage'],
                                'icon' => 'fa fa-user-o',
                            ],
                        ],
                    ]
                ]
            ],

            'account_menu' => [
                'type' => 'ArrayProvider',
                'options' => [
                    'items' => [
                        [
                            'options' => [
                                'label' => 'Profile',
                                'route' => 'user',
                                'params' => ['action' => 'account'],
                                'icon' => 'fa fa-user',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Settings',
                                'route' => 'dashboard',
                                'icon' => 'fa fa-cog',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Sign Out',
                                'route' => 'logout',
                                'icon' => 'fa fa-sign-out',
                            ]
                        ]
                    ]
                ]
            ]
        ],

        //register custom providers here
        'provider_manager' => []
    ],
];
