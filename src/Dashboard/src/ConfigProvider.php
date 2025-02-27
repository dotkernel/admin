<?php

declare(strict_types=1);

namespace Admin\Dashboard;

use Admin\Dashboard\Handler\GetDashboardViewHandler;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
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
                GetDashboardViewHandler::class => AttributedServiceFactory::class,
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'dashboard' => [__DIR__ . '/../templates/dashboard'],
            ],
        ];
    }
}
