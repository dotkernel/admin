<?php

declare(strict_types=1);

$year = date('Y');
$month = date('m');

return [
    'dot-geoip' => [
        'targetDir' => getcwd() . '/data/geoip/',
        'databases' => [
            'asn' => [
                'source' => sprintf('https://download.db-ip.com/free/dbip-asn-lite-%d-%s.mmdb.gz', $year, $month)
            ],
            'city' => [
                'source' => sprintf('https://download.db-ip.com/free/dbip-city-lite-%d-%s.mmdb.gz', $year, $month)
            ],
            'country' => [
                'source' => sprintf('https://download.db-ip.com/free/dbip-country-lite-%d-%s.mmdb.gz', $year, $month)
            ]
        ]
    ]
];
