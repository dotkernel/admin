<?php

declare(strict_types=1);

namespace Admin\App;

use Admin\App\Handler\GetIndexRedirectHandler;
use Admin\App\Plugin\FormsPlugin;
use Admin\App\Twig\Extension\RouteExtension;
use Dot\Controller\Factory\PluginManagerFactory;
use Dot\Controller\Plugin\PluginManager;
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
                Application::class => [RoutesDelegator::class],
            ],
            'factories'  => [
                GetIndexRedirectHandler::class => AttributedServiceFactory::class,
                PluginManager::class           => PluginManagerFactory::class,
                FormsPlugin::class             => AttributedServiceFactory::class,
                RouteExtension::class          => AttributedServiceFactory::class,
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'error'   => [__DIR__ . '/../templates/error'],
                'layout'  => [__DIR__ . '/../templates/layout'],
                'partial' => [__DIR__ . '/../templates/partial'],
            ],
        ];
    }
}
