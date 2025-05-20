<?php

declare(strict_types=1);

namespace Admin\Dashboard;

use Admin\Dashboard\Handler\GetDashboardViewHandler;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;

/**
 * @phpstan-type ConfigType array{
 *      dependencies: DependenciesType,
 *      templates: TemplatesType,
 * }
 * @phpstan-type DependenciesType array{
 *      delegators: non-empty-array<class-string, array<class-string>>,
 *      factories: non-empty-array<class-string, class-string>,
 * }
 * @phpstan-type TemplatesType array{
 *      paths: non-empty-array<non-empty-string, non-empty-string[]>,
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
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * @return DependenciesType
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [RoutesDelegator::class],
            ],
            'factories'  => [
                GetDashboardViewHandler::class => AttributedServiceFactory::class,
            ],
        ];
    }

    /**
     * @return TemplatesType
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'dashboard' => [__DIR__ . '/../templates/dashboard'],
            ],
        ];
    }
}
