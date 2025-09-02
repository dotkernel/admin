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
use Admin\Admin\Handler\Account\GetEditAccountFormHandler;
use Admin\Admin\Handler\Account\GetLoginAccountFormHandler;
use Admin\Admin\Handler\Account\GetLogoutAccountHandler;
use Admin\Admin\Handler\Account\PostChangeAccountPasswordHandler;
use Admin\Admin\Handler\Account\PostEditAccountHandler;
use Admin\Admin\Handler\Account\PostLoginAccountHandler;
use Admin\Admin\Handler\Admin\GetCreateAdminFormHandler;
use Admin\Admin\Handler\Admin\GetDeleteAdminFormHandler;
use Admin\Admin\Handler\Admin\GetEditAdminFormHandler;
use Admin\Admin\Handler\Admin\GetListAdminHandler;
use Admin\Admin\Handler\Admin\GetListAdminLoginHandler;
use Admin\Admin\Handler\Admin\PostCreateAdminHandler;
use Admin\Admin\Handler\Admin\PostDeleteAdminHandler;
use Admin\Admin\Handler\Admin\PostEditAdminHandler;
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

/**
 * @phpstan-type ConfigType array{
 *      dependencies: DependenciesType,
 *      templates: TemplatesType,
 * }
 * @phpstan-type DependenciesType array{
 *      delegators: non-empty-array<class-string, array<class-string>>,
 *      factories: non-empty-array<class-string, class-string>,
 *      aliases: non-empty-array<class-string, class-string>,
 * }
 * @phpstan-type TemplatesType array{
 *      paths: non-empty-array<non-empty-string, non-empty-string[]>,
 * }
 */
class ConfigProvider
{
    /**
     * @return ConfigType
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * @return DependenciesType
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class     => [RoutesDelegator::class],
                CreateAdminForm::class => [AdminRoleDelegator::class],
            ],
            'factories'  => [
                GetCreateAdminFormHandler::class        => AttributedServiceFactory::class,
                PostCreateAdminHandler::class           => AttributedServiceFactory::class,
                GetEditAdminFormHandler::class          => AttributedServiceFactory::class,
                PostEditAdminHandler::class             => AttributedServiceFactory::class,
                GetDeleteAdminFormHandler::class        => AttributedServiceFactory::class,
                PostDeleteAdminHandler::class           => AttributedServiceFactory::class,
                GetListAdminHandler::class              => AttributedServiceFactory::class,
                GetListAdminLoginHandler::class         => AttributedServiceFactory::class,
                GetEditAccountFormHandler::class        => AttributedServiceFactory::class,
                PostEditAccountHandler::class           => AttributedServiceFactory::class,
                PostChangeAccountPasswordHandler::class => AttributedServiceFactory::class,
                GetLoginAccountFormHandler::class       => AttributedServiceFactory::class,
                PostLoginAccountHandler::class          => AttributedServiceFactory::class,
                GetLogoutAccountHandler::class          => AttributedServiceFactory::class,
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

    /**
     * @return TemplatesType
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'admin' => [__DIR__ . '/../templates/admin'],
            ],
        ];
    }
}
