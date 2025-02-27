<?php

declare(strict_types=1);

namespace Admin\Admin;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Controller\AdminController;
use Admin\Admin\Delegator\AdminRoleDelegator;
use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminInterface;
use Admin\Admin\Factory\AuthenticationServiceFactory;
use Admin\Admin\Form\AdminDeleteForm;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Form\LoginForm;
use Admin\Admin\Handler\Account\PostAccountChangePasswordHandler;
use Admin\Admin\Handler\Account\PostAccountEditHandler;
use Admin\Admin\Handler\Account\GetAccountEditFormHandler;
use Admin\Admin\Handler\Account\GetAccountLoginFormHandler;
use Admin\Admin\Handler\Account\PostAccountLoginHandler;
use Admin\Admin\Handler\Account\GetAccountLogoutHandler;
use Admin\Admin\Handler\Admin\PostAdminDeleteHandler;
use Admin\Admin\Handler\Admin\PostAdminEditHandler;
use Admin\Admin\Handler\Admin\GetAdminListHandler;
use Admin\Admin\Handler\Admin\GetAdminCreateFormHandler;
use Admin\Admin\Handler\Admin\GetAdminDeleteFormHandler;
use Admin\Admin\Handler\Admin\GetAdminEditFormHandler;
use Admin\Admin\Handler\Admin\GetAdminLoginListHandler;
use Admin\Admin\Handler\Admin\PostAdminCreateHandler;
use Admin\Admin\Repository\AdminLoginRepository;
use Admin\Admin\Repository\AdminRepository;
use Admin\Admin\Repository\AdminRoleRepository;
use Admin\Admin\Service\AdminRoleService;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminService;
use Admin\Admin\Service\AdminServiceInterface;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Dot\DependencyInjection\Factory\AttributedRepositoryFactory;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Laminas\Authentication\AuthenticationService;
use Laminas\Form\ElementFactory;
use Mezzio\Application;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'form'         => $this->getForms(),
            'doctrine'     => $this->getDoctrineConfig(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
                AdminForm::class   => [
                    AdminRoleDelegator::class,
                ],
            ],
            'factories'  => [
                AdminController::class                 => AttributedServiceFactory::class,
                GetAdminCreateFormHandler::class       => AttributedServiceFactory::class,
                PostAdminCreateHandler::class        => AttributedServiceFactory::class,
                GetAdminEditFormHandler::class         => AttributedServiceFactory::class,
                PostAdminEditHandler::class        => AttributedServiceFactory::class,
                GetAdminDeleteFormHandler::class       => AttributedServiceFactory::class,
                PostAdminDeleteHandler::class      => AttributedServiceFactory::class,
                GetAdminListHandler::class       => AttributedServiceFactory::class,
                GetAdminLoginListHandler::class   => AttributedServiceFactory::class,
                GetAccountEditFormHandler::class      => AttributedServiceFactory::class,
                PostAccountEditHandler::class => AttributedServiceFactory::class,
                PostAccountChangePasswordHandler::class           => AttributedServiceFactory::class,
                GetAccountLoginFormHandler::class        => AttributedServiceFactory::class,
                PostAccountLoginHandler::class                    => AttributedServiceFactory::class,
                GetAccountLogoutHandler::class                   => AttributedServiceFactory::class,
                AdminService::class                    => AttributedServiceFactory::class,
                AdminRoleService::class                => AttributedServiceFactory::class,
                AdminRepository::class                 => AttributedRepositoryFactory::class,
                AdminRoleRepository::class             => AttributedRepositoryFactory::class,
                AdminLoginRepository::class            => AttributedRepositoryFactory::class,
                AdminForm::class                       => ElementFactory::class,
                AuthenticationService::class           => AuthenticationServiceFactory::class,
                AuthenticationAdapter::class           => AttributedServiceFactory::class,
            ],
            'aliases'    => [
                AdminInterface::class            => Admin::class,
                AdminServiceInterface::class     => AdminService::class,
                AdminRoleServiceInterface::class => AdminRoleService::class,
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'admin' => [__DIR__ . '/../templates/admin'],
            ],
        ];
    }

    public function getForms(): array
    {
        return [
            'form_manager' => [
                'factories'  => [
                    AdminForm::class          => ElementFactory::class,
                    LoginForm::class          => ElementFactory::class,
                    ChangePasswordForm::class => ElementFactory::class,
                    AdminDeleteForm::class    => ElementFactory::class,
                ],
                'aliases'    => [],
                'delegators' => [],
            ],
        ];
    }

    public function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default'   => [
                    'drivers' => [
                        'Admin\Admin\Entity' => 'AdminEntities',
                    ],
                ],
                'AdminEntities' => [
                    'class' => AttributeDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }
}
