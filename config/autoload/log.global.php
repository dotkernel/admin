<?php

use Zend\Log\Logger;

return [
    'dot_log' => [
        'loggers' => [
            'action_logger' => [
                'writers' => [
                    [
                        'name' => 'db',
                        'priority' => Logger::INFO,
                        'options' => [

                            'db' => 'database',
                            'table' => 'log_admin_action',

                            'column' => [
                                'message' => 'message',
                                'extra' => [
                                    'ip' => 'ip',
                                    'agentId' => 'agentId',
                                    'agentName' => 'agentName',
                                    'type' => 'type',
                                    'targetId' => 'targetId',
                                    'target' => 'target',
                                    'status' => 'status',
                                ],
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ],
];
