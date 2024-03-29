<?php

declare(strict_types=1);

use Dot\Cli\Command\DemoCommand;
use Dot\Cli\FileLockerInterface;

return [
    /**
     * Documentation: https://docs.laminas.dev/laminas-cli/
     */
    'dot_cli'                  => [
        'version'  => '1.0.0',
        'name'     => 'DotKernel CLI',
        'commands' => [
            DemoCommand::getDefaultName()                    => DemoCommand::class,
            Dot\GeoIP\Command\GeoIpCommand::getDefaultName() => Dot\GeoIP\Command\GeoIpCommand::class,
        ],
    ],
    FileLockerInterface::class => [
        'enabled' => true,
        'dirPath' => getcwd() . '/data/lock',
    ],
];
