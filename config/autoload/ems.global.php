<?php

return [
    'dot_ems' => [

        'mapper_manager' => [
            'factories' => [
                \Dot\Admin\Mapper\EntityDbMapper::class => \Dot\Ems\Factory\RelationalDbMapperFactory::class,
            ],
            'aliases' => [
                'EntityDbMapper' => \Dot\Admin\Mapper\EntityDbMapper::class,
            ]
        ],

        'services' => [
            'user' => [
                'atomic_operations' => true,
                'type' => \Dot\Admin\Service\UserService::class,

                'event_listeners' => [
                    \Dot\Admin\Listener\EntityServiceListener::class,
                ],

                'mapper' => [
                    'EntityDbMapper' => [
                        'adapter' => 'database',
                        'table' => 'user',

                        'entity_prototype' => \Dot\Admin\Entity\User\UserEntity::class,
                        'entity_hydrator' => \Dot\User\Entity\UserEntityHydrator::class,

                        'relations' => [
                            'HasOne' => [
                                'field_name' => 'details',
                                'ref_name' => 'userId',

                                'delete_refs' => true,
                                'change_refs' => true,

                                'mapper' => [
                                    'DbMapper' => [
                                        'adapter' => 'database',
                                        'table' => 'user_details',

                                        'identifier_name' => 'userId',
                                        'entity_prototype' => \Dot\Admin\Entity\User\UserDetailsEntity::class,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'admin' => [
                'atomic_operations' => true,
                'type' => \Dot\Admin\Service\AdminService::class,

                'event_listeners' => [
                    \Dot\Admin\Listener\EntityServiceListener::class,
                ],

                'mapper' => [
                    'EntityDbMapper' => [
                        'adapter' => 'database',
                        'table' => 'admin',

                        'entity_prototype' => \Dot\Admin\Entity\Admin\AdminEntity::class,
                        'entity_hydrator' => \Dot\User\Entity\UserEntityHydrator::class,
                    ]
                ],
            ],

        ],
    ]
];
