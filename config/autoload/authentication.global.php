<?php

declare(strict_types=1);

use Admin\Admin\Entity\Admin;

return [
    'doctrine' => [
        'authentication' => [
            'orm_default' => [
                'object_manager'      => 'doctrine.entitymanager.orm_default',
                'identity_class'      => Admin::class,
                'identity_property'   => 'identity',
                'credential_property' => 'password',
                'messages'            => [
                    'success'            => 'Authenticated successfully.',
                    'not_found'          => 'Identity not found.',
                    'invalid_credential' => 'Invalid credentials.',
                ],
            ],
        ],
    ],
];
