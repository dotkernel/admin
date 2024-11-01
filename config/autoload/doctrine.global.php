<?php

declare(strict_types=1);

use Admin\Admin\DBAL\Types\AdminStatusEnumType;
use Admin\App\DBAL\Types\SuccessFailureEnumType;
use Admin\App\DBAL\Types\YesNoEnumType;
use Admin\App\Resolver\EntityListenerResolver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Dot\Cache\Adapter\ArrayAdapter;
use Dot\Cache\Adapter\FilesystemAdapter;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\Doctrine\UuidBinaryType;
use Ramsey\Uuid\Doctrine\UuidType;

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'entity_listener_resolver' => EntityListenerResolver::class,
                'result_cache'             => 'filesystem',
                'metadata_cache'           => 'filesystem',
                'query_cache'              => 'filesystem',
                'hydration_cache'          => 'array',
                'typed_field_mapper'       => null,
                'second_level_cache'       => [
                    'enabled'                    => true,
                    'default_lifetime'           => 3600,
                    'default_lock_lifetime'      => 60,
                    'file_lock_region_directory' => '',
                    'regions'                    => [],
                ],
            ],
        ],
        'connection'    => [
            'orm_default' => [
                'doctrine_mapping_types' => [
                    UuidBinaryType::NAME            => 'binary',
                    UuidBinaryOrderedTimeType::NAME => 'binary',
                ],
            ],
        ],
        'driver'        => [
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'class'   => MappingDriverChain::class,
                'drivers' => [],
            ],
        ],
        'types'         => [
            UuidType::NAME                  => UuidType::class,
            UuidBinaryType::NAME            => UuidBinaryType::class,
            UuidBinaryOrderedTimeType::NAME => UuidBinaryOrderedTimeType::class,
            AdminStatusEnumType::NAME       => AdminStatusEnumType::class,
            SuccessFailureEnumType::NAME    => SuccessFailureEnumType::class,
            YesNoEnumType::NAME             => YesNoEnumType::class,
        ],
        'cache'         => [
            'array'      => [
                'class' => ArrayAdapter::class,
            ],
            'filesystem' => [
                'class'     => FilesystemAdapter::class,
                'directory' => getcwd() . '/data/cache',
                'namespace' => 'doctrine',
            ],
        ],
        'fixtures'      => getcwd() . '/data/doctrine/fixtures',
    ],
];
