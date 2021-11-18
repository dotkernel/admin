<?php

declare(strict_types=1);

namespace Frontend\App;

use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Dot\AnnotatedServices\Factory\AnnotatedServiceFactory;
use Dot\Controller\Factory\PluginManagerFactory;
use Dot\Controller\Plugin\PluginManager;
use Frontend\App\Controller\DashboardController;
use Frontend\App\Controller\LanguageController;
use Frontend\App\Factory\EntityListenerResolverFactory;
use Frontend\App\Factory\FormsPluginFactory;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\App\Resolver\EntityListenerResolver;
use Frontend\App\Service\TranslateService;
use Frontend\App\Service\TranslateServiceInterface;
use Mezzio\Application;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'     => $this->getDoctrineConfig(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    \Frontend\App\RoutesDelegator::class,
                    \Frontend\User\RoutesDelegator::class
                ]
            ],
            'factories'  => [
                'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
                EntityListenerResolver::class => EntityListenerResolverFactory::class,
                TranslateService::class => AnnotatedServiceFactory::class,
                LanguageController::class => AnnotatedServiceFactory::class,
                DashboardController::class => AnnotatedServiceFactory::class,
                PluginManager::class => PluginManagerFactory::class,
                FormsPlugin::class => FormsPluginFactory::class
            ],
            'aliases' => [
                EntityManager::class => 'doctrine.entity_manager.orm_default',
                EntityManagerInterface::class => 'doctrine.entity_manager.default',
                TranslateServiceInterface::class => TranslateService::class,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getDoctrineConfig(): array
    {
        return [
            'configuration' => [
                'orm_default' => [
                    'entity_listener_resolver' => EntityListenerResolver::class,
                ]
            ]
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
                'partial' => [__DIR__ . '/../templates/partial'],
                'language' => [__DIR__ . '/../templates/language'],
            ],
        ];
    }
}
