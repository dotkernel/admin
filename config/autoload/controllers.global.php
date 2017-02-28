<?php

return [
    'dependencies' => [],

    'dot_controller' => [
        'plugin_manager' => [],

        'event_listeners' => [
            \Dot\Controller\Event\ControllerEventListenerInterface::LISTEN_ALL =>
                \Dot\Admin\Listener\ControllerEventsListener::class,
        ],
    ],
];
