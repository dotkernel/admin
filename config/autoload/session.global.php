<?php

declare(strict_types=1);

return [
    'dot_flashmessenger' => [
        'options' => [
            'namespace' => 'admin_messenger'
        ]
    ],
    'dot_session' => [
        'cookieName' => 'remember_me_token',
        'rememberMeInactive' => 1800,
    ],
    'session_config' => [
        'name' => 'ADMIN_SESSID',
    ],
    'session_containers' => [
        'user'
    ]
];
