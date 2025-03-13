<?php

declare(strict_types=1);

namespace Admin\App;

use Admin\App\Factory\FormsPluginFactory;
use Admin\App\Handler\GetIndexRedirectHandler;
use Admin\App\Plugin\FormsPlugin;
use Admin\App\Twig\Extension\RouteExtension;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Dot\Controller\Factory\PluginManagerFactory;
use Dot\Controller\Plugin\PluginManager;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

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
                'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
                GetIndexRedirectHandler::class        => AttributedServiceFactory::class,
                PluginManager::class                  => PluginManagerFactory::class,
                FormsPlugin::class                    => FormsPluginFactory::class,
                RouteExtension::class                 => AttributedServiceFactory::class,
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
                'error'   => [__DIR__ . '/../templates/error'],
                'layout'  => [__DIR__ . '/../templates/layout'],
                'partial' => [__DIR__ . '/../templates/partial'],
            ],
        ];
    }
}
