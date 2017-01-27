<?php

return [

    'dependencies' => [
        'factories' => [
            \Dot\Admin\Controller\DashboardController::class =>
                \Zend\ServiceManager\Factory\InvokableFactory::class,
        ]
    ],

    'dot_controller' => [

        'plugin_manager' => [],

        'event_listeners' => [
            \Dot\Controller\Event\ControllerEventListenerInterface::LISTEN_ALL =>
                \Dot\Admin\Listener\ControllerEventsListener::class,
        ],
    ],
];
