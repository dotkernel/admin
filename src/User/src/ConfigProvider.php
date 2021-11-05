<?php

declare(strict_types=1);

namespace Frontend\User;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Dot\AnnotatedServices\Factory\AnnotatedServiceFactory;
use Frontend\User\Authentication\AuthenticationAdapter;
use Frontend\User\Authentication\AuthenticationAdapterFactory;
use Frontend\User\Authentication\AuthenticationServiceFactory;
use Frontend\User\Controller\AdminController;
use Frontend\User\Doctrine\EntityListenerResolver;
use Frontend\User\Doctrine\EntityListenerResolverFactory;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminInterface;
use Frontend\User\Factory\AdminControllerFactory;
use Frontend\User\Factory\AdminRoleDelegator;
use Frontend\User\Factory\UserControllerFactory;
use Frontend\User\Factory\UserRoleDelegator;
use Frontend\User\Form\AdminForm;
use Frontend\User\Form\ChangePasswordForm;
use Frontend\User\Form\LoginForm;
use Frontend\User\Controller\UserController;
use Frontend\User\Form\UserForm;
use Frontend\User\Service\AdminService;
use Frontend\User\Service\UserRoleService;
use Frontend\User\Service\UserRoleServiceInterface;
use Frontend\User\Service\UserService;
use Frontend\User\Service\UserServiceInterface;
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
                UserController::class => UserControllerFactory::class,
                AdminController::class => AdminControllerFactory::class,
                EntityListenerResolver::class => EntityListenerResolverFactory::class,
                UserService::class => AnnotatedServiceFactory::class,
                AdminService::class => AnnotatedServiceFactory::class,
                UserRoleService::class => AnnotatedServiceFactory::class,
                AdminForm::class => ElementFactory::class,
                UserForm::class => ElementFactory::class,
                AuthenticationService::class => AuthenticationServiceFactory::class,
                AuthenticationAdapter::class => AuthenticationAdapterFactory::class,
            ],
            'aliases' => [
                AdminInterface::class => Admin::class,
                UserServiceInterface::class => UserService::class,
                UserRoleServiceInterface::class => UserRoleService::class,
            ],
            'delegators' => [
                AdminForm::class => [
                    AdminRoleDelegator::class
                ],
                UserForm::class => [
                    UserRoleDelegator::class
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
                'user' => [__DIR__ . '/../templates/user'],
                'admin' => [__DIR__ . '/../templates/admin']
            ],
        ];
    }

    public function getForms()
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

    public function getDoctrineConfig()
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
                        'Frontend\User\Entity' => 'UserEntities',
                    ]
                ],
                'UserEntities' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ]
            ]
        ];
    }
}
