<?php

declare(strict_types=1);

namespace Admin\Admin;

use Admin\Admin\Adapter\AuthenticationAdapter;
use Admin\Admin\Delegator\AdminRoleDelegator;
use Admin\Admin\Factory\AuthenticationServiceFactory;
use Admin\Admin\Form\AdminDeleteForm;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Form\ChangePasswordForm;
use Admin\Admin\Form\LoginForm;
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
                AdminForm::class                        => ElementFactory::class,
                AuthenticationService::class            => AuthenticationServiceFactory::class,
                AuthenticationAdapter::class            => AttributedServiceFactory::class,
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
}
