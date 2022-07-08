<?php

declare(strict_types=1);

namespace Frontend\User;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Dot\AnnotatedServices\Factory\AnnotatedServiceFactory;
use Frontend\Admin\Authentication\AuthenticationAdapter;
use Frontend\Admin\Authentication\AuthenticationServiceFactory;
use Frontend\Admin\Controller\AdminController;
use Frontend\Admin\Doctrine\EntityListenerResolver;
use Frontend\Admin\Doctrine\EntityListenerResolverFactory;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminInterface;
use Frontend\Admin\Delegator\AdminRoleDelegator;
use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Form\ChangePasswordForm;
use Frontend\Admin\Form\LoginForm;
use Frontend\Admin\Service\AdminService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Form\ElementFactory;

/**
 * Class ConfigProvider
 * @package Frontend\Admin
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'dot_form' => $this->getForms(),
            'doctrine' => $this->getDoctrineConfig(),
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'factories'  => [
                AdminController::class => AnnotatedServiceFactory::class,
                EntityListenerResolver::class => EntityListenerResolverFactory::class,
                AdminService::class => AnnotatedServiceFactory::class,
                AdminForm::class => ElementFactory::class,
                AuthenticationService::class => AuthenticationServiceFactory::class,
                AuthenticationAdapter::class => AnnotatedServiceFactory::class
            ],
            'aliases' => [
                AdminInterface::class => Admin::class
            ],
            'delegators' => [
                AdminForm::class => [
                    AdminRoleDelegator::class
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'admin' => [__DIR__ . '/../templates/admin']
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function getForms(): array
    {
        return [
            'form_manager' => [
                'factories' => [
                    LoginForm::class => ElementFactory::class,
                    ChangePasswordForm::class => ElementFactory::class
                ],
                'aliases' => [
                ],
                'delegators' => [
                ]
            ],
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
            ],
            'driver' => [
                'orm_default' => [
                    'drivers' => [
                        'Frontend\Admin\Entity' => 'AdminEntities',
                    ]
                ],
                'AdminEntities' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ]
            ]
        ];
    }
}
