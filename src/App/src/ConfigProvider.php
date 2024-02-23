<?php

declare(strict_types=1);

namespace Frontend\App;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Dot\AnnotatedServices\Factory\AnnotatedServiceFactory;
use Dot\Controller\Factory\PluginManagerFactory;
use Dot\Controller\Plugin\PluginManager;
use Frontend\App\Controller\DashboardController;
use Frontend\App\Controller\PageController;
use Frontend\App\Factory\EntityListenerResolverFactory;
use Frontend\App\Factory\FormsPluginFactory;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\App\Resolver\EntityListenerResolver;
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
                    \Frontend\Admin\RoutesDelegator::class,
                    \Frontend\Setting\RoutesDelegator::class,
                ],
            ],
            'factories'  => [
                EntityListenerResolver::class => EntityListenerResolverFactory::class,
                DashboardController::class    => AnnotatedServiceFactory::class,
                PageController::class         => AnnotatedServiceFactory::class,
                PluginManager::class          => PluginManagerFactory::class,
                FormsPlugin::class            => FormsPluginFactory::class,
            ],
            'aliases'    => [
                EntityManager::class          => 'doctrine.entity_manager.orm_default',
                EntityManagerInterface::class => 'doctrine.entity_manager.orm_default',
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'      => [__DIR__ . '/../templates/app'],
                'error'    => [__DIR__ . '/../templates/error'],
                'layout'   => [__DIR__ . '/../templates/layout'],
                'partial'  => [__DIR__ . '/../templates/partial'],
                'language' => [__DIR__ . '/../templates/language'],
            ],
        ];
    }
}
