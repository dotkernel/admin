<?php

return [
    'doctrine' => [
        'authentication' => [
            'orm_default' => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'identity_class' => \Frontend\User\Entity\User::class,
                'identity_property' => 'username',
                'credential_property' => 'password',
                'credential_callable' => 'Frontend\User\Doctrine\UserAuthentication::verifyCredential',
            ],
        ],
    ],
];
