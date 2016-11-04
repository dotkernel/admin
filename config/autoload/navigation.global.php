<?php

return [
    'dot_navigation' => [

        //enable menu item active if any child is active
        'active_recursion' => true,

        //map a provider name to a provider type
        'providers_map' => [
            'main_menu' => \Dot\Navigation\Provider\ArrayProvider::class,
            'account_menu' => \Dot\Navigation\Provider\ArrayProvider::class,
        ],

        //map a provider name to its config
        //this is for bootstrap navbar - even if we support multi-level menus, bootstrap is limited to one level
        'containers' => [
            'main_menu' => [
                [
                    'options' => [
                        'label' => 'Dashboard',
                        'route' => 'dashboard',
                        'icon' => 'fa fa-tachometer',
                    ]
                ],
                [
                    'options' => [
                        'label' => 'Manage admins',
                        'uri' => '#',
                        'icon' => 'fa fa-user-circle-o',
                    ],
                    'pages' => [
                        [
                            'options' => [
                                'label' => 'List admins',
                                'route' => 'user',
                                'params' => ['action' => 'list'],
                                'icon' => 'fa fa-list',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Add admin',
                                'route' => 'user',
                                'params' => ['action' => 'add'],
                                'icon' => 'fa fa-plus',
                            ],
                        ]
                    ]
                ],
                [
                    'options' => [
                        'label' => 'Manage users',
                        'uri' => '#',
                        'icon' => 'fa fa-user-o',
                    ],
                    'pages' => [
                        [
                            'options' => [
                                'label' => 'List users',
                                'route' => 'f_user',
                                'params' => ['action' => 'list'],
                                'icon' => 'fa fa-list',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Add user',
                                'route' => 'f_user',
                                'params' => ['action' => 'add'],
                                'icon' => 'fa fa-plus',
                            ],
                        ]
                    ]
                ],
            ],

            'account_menu' => [
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

        ],

        //register custom providers here
        'provider_manager' => [

        ]
    ],
];