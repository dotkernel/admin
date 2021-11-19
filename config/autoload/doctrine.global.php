<?php

declare(strict_types=1);

use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\Doctrine\UuidBinaryType;
use Ramsey\Uuid\Doctrine\UuidType;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

return [
    'dependencies' => [
        'factories' => [
            'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
        ],
        'aliases' => [
            EntityManager::class => 'doctrine.entity_manager.orm_default',
            EntityManagerInterface::class => 'doctrine.entity_manager.default',
            'doctrine.entitymanager.orm_default' => 'doctrine.entity_manager.orm_default'
        ]
    ],

    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'doctrine_mapping_types' => [
                    UuidBinaryType::NAME => 'binary',
                    UuidBinaryOrderedTimeType::NAME => 'binary',
                ]
            ]
        ],
        'driver' => [
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [],
            ],
        ],
        'types' => [
            UuidType::NAME => UuidType::class,
            UuidBinaryType::NAME => UuidBinaryType::class,
            UuidBinaryOrderedTimeType::NAME => UuidBinaryOrderedTimeType::class,
        ],
        'cache' => [
            PhpFileCache::class => [
                'class' => PhpFileCache::class,
                'directory' => getcwd() . '/data/cache/doctrine'
            ]
        ]
    ],
    'resultCacheLifetime' => 300
];
