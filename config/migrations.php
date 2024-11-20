<?php

declare(strict_types=1);

return [
    'table_storage'           => [
        'table_name'                 => 'migrations',
        'version_column_name'        => 'version',
        'version_column_length'      => 191,
        'executed_at_column_name'    => 'executed_at',
        'execution_time_column_name' => 'execution_time',
    ],
    'migrations_paths'        => [
        'Admin\Migrations' => getcwd() . '/data/doctrine/migrations',
    ],
    'all_or_nothing'          => true,
    'transactional'           => true,
    'check_database_platform' => true,
    'organize_migrations'     => 'none',
    'connection'              => null,
    'em'                      => null,
];
