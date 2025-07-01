<?php

declare(strict_types=1);

namespace Core\NotificationSystem;

use Core\NotificationSystem\Service\NotificationService;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;

/**
 * @phpstan-type ConfigType array{
 *      dependencies: DependenciesType,
 * }
 * @phpstan-type DependenciesType array{
 *       factories: array<class-string, class-string>,
 * }
 */
class ConfigProvider
{
    /**
     * @return ConfigType
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return DependenciesType
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                NotificationService::class => AttributedServiceFactory::class,
            ],
        ];
    }
}
