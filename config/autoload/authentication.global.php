<?php

return [
    'doctrine' => [
        'authentication' => [
            'orm_default' => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'identity_class' => \Frontend\User\Entity\Admin::class,
                'identity_property' => 'identity',
                'credential_property' => 'password',
                'credential_callable' => 'Frontend\User\Doctrine\UserAuthentication::verifyCredential',
                'messages' => [
                    'success' => 'Authenticated successfully.',
                    'not_found' => 'Identity not found.',
                    'invalid_credential' => 'Invalid credentials.',
                ],
            ],
        ],
    ],
];
