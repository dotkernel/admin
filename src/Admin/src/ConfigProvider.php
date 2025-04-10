<?php

declare(strict_types=1);

namespace Admin\Admin;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Delegator\AdminRoleDelegator;
use Admin\Admin\Factory\AuthenticationServiceFactory;
use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\CreateAdminForm;
use Admin\Admin\Form\DeleteAdminForm;
use Admin\Admin\Form\EditAdminForm;
use Admin\Admin\Handler\Account\GetAccountEditFormHandler;
use Admin\Admin\Handler\Account\GetAccountLoginFormHandler;
use Admin\Admin\Handler\Account\GetAccountLogoutHandler;
use Admin\Admin\Handler\Account\PostAccountChangePasswordHandler;
use Admin\Admin\Handler\Account\PostAccountEditHandler;
use Admin\Admin\Handler\Account\PostAccountLoginHandler;
use Admin\Admin\Handler\Admin\GetAdminCreateFormHandler;
use Admin\Admin\Handler\Admin\GetAdminDeleteFormHandler;
use Admin\Admin\Handler\Admin\GetAdminEditFormHandler;
use Admin\Admin\Handler\Admin\GetAdminListHandler;
use Admin\Admin\Handler\Admin\GetAdminLoginListHandler;
use Admin\Admin\Handler\Admin\PostAdminCreateHandler;
use Admin\Admin\Handler\Admin\PostAdminDeleteHandler;
use Admin\Admin\Handler\Admin\PostAdminEditHandler;
use Admin\Admin\Service\AdminLoginService;
use Admin\Admin\Service\AdminLoginServiceInterface;
use Admin\Admin\Service\AdminRoleService;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminService;
use Admin\Admin\Service\AdminServiceInterface;
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
        ];
    }

    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class     => [RoutesDelegator::class],
                CreateAdminForm::class => [AdminRoleDelegator::class],
            ],
            'factories'  => [
                GetAdminCreateFormHandler::class        => AttributedServiceFactory::class,
                PostAdminCreateHandler::class           => AttributedServiceFactory::class,
                GetAdminEditFormHandler::class          => AttributedServiceFactory::class,
                PostAdminEditHandler::class             => AttributedServiceFactory::class,
                GetAdminDeleteFormHandler::class        => AttributedServiceFactory::class,
                PostAdminDeleteHandler::class           => AttributedServiceFactory::class,
                GetAdminListHandler::class              => AttributedServiceFactory::class,
                GetAdminLoginListHandler::class         => AttributedServiceFactory::class,
                GetAccountEditFormHandler::class        => AttributedServiceFactory::class,
                PostAccountEditHandler::class           => AttributedServiceFactory::class,
                PostAccountChangePasswordHandler::class => AttributedServiceFactory::class,
                GetAccountLoginFormHandler::class       => AttributedServiceFactory::class,
                PostAccountLoginHandler::class          => AttributedServiceFactory::class,
                GetAccountLogoutHandler::class          => AttributedServiceFactory::class,
                AuthenticationAdapter::class            => AttributedServiceFactory::class,
                AdminService::class                     => AttributedServiceFactory::class,
                AdminRoleService::class                 => AttributedServiceFactory::class,
                AdminLoginService::class                => AttributedServiceFactory::class,
                AuthenticationService::class            => AuthenticationServiceFactory::class,
                AccountForm::class                      => ElementFactory::class,
                CreateAdminForm::class                  => ElementFactory::class,
                DeleteAdminForm::class                  => ElementFactory::class,
                EditAdminForm::class                    => ElementFactory::class,
            ],
            'aliases'    => [
                AdminServiceInterface::class      => AdminService::class,
                AdminRoleServiceInterface::class  => AdminRoleService::class,
                AdminLoginServiceInterface::class => AdminLoginService::class,
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
}
