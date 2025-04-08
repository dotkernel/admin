<?php

declare(strict_types=1);

use Core\App\Command\RouteListCommand;
use Dot\Cli\FileLockerInterface;
use Dot\GeoIP\Command\GeoIpCommand;

return [
    /**
     * Documentation: https://docs.laminas.dev/laminas-cli/
     */
    'dot_cli'                  => [
        'version'  => '1.0.0',
        'name'     => 'Dotkernel CLI',
        'commands' => [
            RouteListCommand::getDefaultName() => RouteListCommand::class,
            GeoIpCommand::getDefaultName()     => GeoIpCommand::class,
        ],
    ],
    FileLockerInterface::class => [
        'enabled' => true,
        'dirPath' => getcwd() . '/data/lock',
    ],
];
