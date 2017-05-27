<?php

use Admin\Console\Command\HelloCommand;

return [
    'dot_console' => [
        //'name' => 'DotKernel Console',
        //'version' => '1.0.0',

        'commands' => [
            [
                'name' => 'hello',
                'description' => 'Hello, World! command example',
                'handler' => HelloCommand::class,
            ],
        ]
    ]
];
