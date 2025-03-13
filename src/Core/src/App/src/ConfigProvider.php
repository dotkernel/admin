<?php

declare(strict_types=1);

namespace Core\App;

use Core\App\Entity\EntityListenerResolver;
use Core\App\Factory\EntityListenerResolverFactory;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Dot\Cache\Adapter\ArrayAdapter;
use Dot\Cache\Adapter\FilesystemAdapter;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\Doctrine\UuidBinaryType;
use Ramsey\Uuid\Doctrine\UuidType;

use function getcwd;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'     => $this->getDoctrineConfig(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                EntityListenerResolver::class => EntityListenerResolverFactory::class,
            ],
        ];
    }

    private function getDoctrineConfig(): array
    {
        return [
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
            'fixtures'      => getcwd() . '/src/Core/src/App/src/Fixture',
            'migrations'    => [
                'table_storage'           => [
                    'table_name'                 => 'doctrine_migration_versions',
                    'version_column_name'        => 'version',
                    'version_column_length'      => 191,
                    'executed_at_column_name'    => 'executed_at',
                    'execution_time_column_name' => 'execution_time',
                ],
                'migrations_paths'        => [
                    'Core\App\Migration' => 'src/Core/src/App/src/Migration',
                ],
                'all_or_nothing'          => true,
                'check_database_platform' => true,
            ],
            'types'         => [
                UuidType::NAME                  => UuidType::class,
                UuidBinaryType::NAME            => UuidBinaryType::class,
                UuidBinaryOrderedTimeType::NAME => UuidBinaryOrderedTimeType::class,
            ],
        ];
    }
}
