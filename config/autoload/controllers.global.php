<?php

return [

    'dependencies' => [
        'factories' => [
            \Dot\Admin\Controller\DashboardController::class =>
                \Zend\ServiceManager\Factory\InvokableFactory::class,
        ]
    ],

    'dot_controller' => [

        'plugin_manager' => []
    ],
];
