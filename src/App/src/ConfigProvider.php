<?php

declare(strict_types=1);

namespace Admin\App;

use Admin\App\Factory\EntityListenerResolverFactory;
use Admin\App\Factory\FormsPluginFactory;
use Admin\App\Handler\ComponentHandler;
use Admin\App\Handler\IndexHandler;
use Admin\App\Plugin\FormsPlugin;
use Admin\App\Resolver\EntityListenerResolver;
use Admin\App\Twig\Extension\RouteExtension;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
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
                EntityListenerResolver::class         => EntityListenerResolverFactory::class,
                IndexHandler::class                   => AttributedServiceFactory::class,
                ComponentHandler::class               => AttributedServiceFactory::class,
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

    public function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'drivers' => [
                        'Admin\App\Entity' => 'AppEntities',
                    ],
                ],
                'AppEntities' => [
                    'class' => AttributeDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'     => [__DIR__ . '/../templates/app'],
                'error'   => [__DIR__ . '/../templates/error'],
                'layout'  => [__DIR__ . '/../templates/layout'],
                'partial' => [__DIR__ . '/../templates/partial'],
            ],
        ];
    }
}
