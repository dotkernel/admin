<?php

declare(strict_types=1);

namespace Admin\Setting;

use Admin\Setting\Handler\GetSettingHandler;
use Admin\Setting\Handler\StoreSettingHandler;
use Admin\Setting\Repository\SettingRepository;
use Admin\Setting\Service\SettingService;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Dot\DependencyInjection\Factory\AttributedRepositoryFactory;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;

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
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'factories'  => [
                StoreSettingHandler::class => AttributedServiceFactory::class,
                GetSettingHandler::class   => AttributedServiceFactory::class,
                SettingService::class      => AttributedServiceFactory::class,
                SettingRepository::class   => AttributedRepositoryFactory::class,
            ],
        ];
    }

    public function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default'     => [
                    'drivers' => [
                        'Admin\Setting\Entity' => 'SettingEntities',
                    ],
                ],
                'SettingEntities' => [
                    'class' => AttributeDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }
}
