<?php

declare(strict_types=1);

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
                                'route' => [
                                    'route_name' => 'dashboard',
                                ],
                                'icon' => 'fas fa-tachometer-alt',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Manage admins',
                                'route' => '',
                                'icon' => 'fas fa-user-circle',
                            ],
                            'pages' => [
                                [
                                    'options' => [
                                        'label' => 'Admins',
                                        'uri' => '/admin/manage',
                                        'icon' => 'fas fa-user-circle',
                                    ],
                                ],
                                [
                                    'options' => [
                                        'label' => 'Logins',
                                        'uri' => '/admin/logins',
                                        'icon' => 'fas fa-sign-in-alt',
                                    ],
                                ]
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Submenu 1',
                                'route' => '',
                                'icon' => 'fas fa-cog',
                            ],
                            'pages' => [
                                [
                                    'options' => [
                                        'label' => 'Submenu link 1',
                                        'uri' => '#',
                                        'icon' => 'fas fa-square',
                                    ],
                                ],
                                [
                                    'options' => [
                                        'label' => 'Submenu link 2',
                                        'uri' => '#',
                                        'icon' => 'fas fa-square',
                                    ],
                                ]
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Submenu 2',
                                'route' => '',
                                'icon' => 'fas fa-cog',
                            ],
                            'pages' => [
                                [
                                    'options' => [
                                        'label' => 'Submenu link 1',
                                        'uri' => '#',
                                        'icon' => 'fa fa-square',
                                    ],
                                ],
                                [
                                    'options' => [
                                        'label' => 'Submenu link 2',
                                        'uri' => '#',
                                        'icon' => 'fa fa-square',
                                    ],
                                ]
                            ]
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
                                'route' => [
                                    'route_name' => 'admin',
                                    'route_params' => ['action' => 'account']
                                ],
                                'icon' => 'fas fa-user',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Settings',
                                'route' => [
                                    'route_name' => 'dashboard',
                                ],
                                'icon' => 'fas fa-cog',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Sign Out',
                                'route' => [
                                    'route_name' => 'admin',
                                    'route_params' => ['action' => 'logout']
                                ],
                                'icon' => 'fas fa-sign-out-alt',
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
