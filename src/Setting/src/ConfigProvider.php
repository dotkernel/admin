<?php

declare(strict_types=1);

namespace Frontend\Setting;

use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Dot\DependencyInjection\Factory\AttributedRepositoryFactory;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Frontend\Setting\Controller\SettingController;
use Frontend\Setting\Repository\SettingRepository;
use Frontend\Setting\Service\SettingService;

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
                SettingController::class => AttributedServiceFactory::class,
                SettingService::class    => AttributedServiceFactory::class,
                SettingRepository::class => AttributedRepositoryFactory::class,
            ],
        ];
    }

    public function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default'     => [
                    'drivers' => [
                        'Frontend\Setting\Entity' => 'SettingEntities',
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
