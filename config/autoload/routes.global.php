<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
        // Map middleware -> factories here
        'factories' => [
        ],
    ],

    'routes' => [
        [
            'name' => 'dashboard',
            'path' => '/[dashboard[/{action}]]',
            'middleware' => \Dot\Admin\Controller\DashboardController::class,
        ],
        [
            //there is already a route named `user` from dot-user package, so we use a diff one for the frontend user management
            'name' => 'f_user',
            'path' => '/user[/{action}]',
            'middleware' => \Dot\Admin\User\Controller\UserController::class,
        ],
        //change default route paths for user related stuff into admin
        //we will use 'user' for frontend users
        'login_route' => [
            'path' => '/admin/login',
        ],
        'logout_route' => [
            'path' => '/admin/logout',
        ],
        'user_route' => [
            'path' => '/admin[/{action}]',
            'middleware' => [\Dot\Admin\Admin\Controller\AdminController::class],
        ]
    ],
];
