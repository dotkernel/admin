<?php

declare(strict_types=1);

return [
    'dot-geoip' => [
        'targetDir' => getcwd() . '/data/geoip',
        'databases' => [
            'asn'     => [
                'source' => 'https://download.db-ip.com/free/dbip-asn-lite-{year}-{month}.mmdb.gz',
            ],
            'city'    => [
                'source' => 'https://download.db-ip.com/free/dbip-city-lite-{year}-{month}.mmdb.gz',
            ],
            'country' => [
                'source' => 'https://download.db-ip.com/free/dbip-country-lite-{year}-{month}.mmdb.gz',
            ],
        ],
    ],
];
