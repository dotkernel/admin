<?php

declare(strict_types=1);

return [
    'dot_flashmessenger' => [
        'options' => [
            'namespace' => 'admin_messenger',
        ]
    ],
    'dot_session' => [
        'rememberMeInactive' => 1800,
    ],
    'session_config' => [
        'cookie_domain'       => '',
        'cookie_httponly'     => true,
        'cookie_lifetime'     => 3600 * 24 * 30,
        'cookie_path'         => '/',
        'cookie_samesite'     => 'Lax',
        'cookie_secure'       => true,
        'name'                => 'ADMIN_SESSID',
        'remember_me_seconds' => 3600 * 24 * 30,
        'use_cookies'         => true,
    ],
    'session_containers' => [
        'user',
    ],
];
