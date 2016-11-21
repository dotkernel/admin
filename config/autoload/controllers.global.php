<?php

return [

    'dependencies' => [
        'factories' => [
            \Dot\Admin\Controller\DashboardController::class =>
                \Zend\ServiceManager\Factory\InvokableFactory::class,

            \Dot\Admin\Controller\UserController::class =>
                \Dot\Admin\Factory\User\UserControllerFactory::class,

            \Dot\Admin\Admin\Controller\AdminController::class =>
                \Dot\Admin\Admin\Factory\AdminControllerFactory::class,
        ]
    ],

    'dot_controller' => [

        'plugin_manager' => []
    ],
];
