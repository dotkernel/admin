<?php

declare(strict_types=1);

namespace Admin\User;

use Admin\User\Delegator\UserRoleDelegator;
use Admin\User\Form\CreateUserForm;
use Admin\User\Form\DeleteUserForm;
use Admin\User\Form\EditUserForm;
use Admin\User\Handler\GetCreateUserFormHandler;
use Admin\User\Handler\GetDeleteUserFormHandler;
use Admin\User\Handler\GetEditUserFormHandler;
use Admin\User\Handler\GetListUserHandler;
use Admin\User\Handler\PostCreateUserHandler;
use Admin\User\Handler\PostDeleteUserHandler;
use Admin\User\Handler\PostEditUserAvatarHandler;
use Admin\User\Handler\PostEditUserHandler;
use Admin\User\Service\UserAvatarService;
use Admin\User\Service\UserAvatarServiceInterface;
use Admin\User\Service\UserRoleService;
use Admin\User\Service\UserRoleServiceInterface;
use Admin\User\Service\UserService;
use Admin\User\Service\UserServiceInterface;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
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
                Application::class    => [RoutesDelegator::class],
                CreateUserForm::class => [UserRoleDelegator::class],
            ],
            'factories'  => [
                GetCreateUserFormHandler::class  => AttributedServiceFactory::class,
                GetDeleteUserFormHandler::class  => AttributedServiceFactory::class,
                GetEditUserFormHandler::class    => AttributedServiceFactory::class,
                GetListUserHandler::class        => AttributedServiceFactory::class,
                PostEditUserAvatarHandler::class => AttributedServiceFactory::class,
                PostCreateUserHandler::class     => AttributedServiceFactory::class,
                PostDeleteUserHandler::class     => AttributedServiceFactory::class,
                PostEditUserHandler::class       => AttributedServiceFactory::class,
                UserAvatarService::class         => AttributedServiceFactory::class,
                UserRoleService::class           => AttributedServiceFactory::class,
                UserService::class               => AttributedServiceFactory::class,
                CreateUserForm::class            => ElementFactory::class,
                DeleteUserForm::class            => ElementFactory::class,
                EditUserForm::class              => ElementFactory::class,
            ],
            'aliases'    => [
                UserAvatarServiceInterface::class => UserAvatarService::class,
                UserRoleServiceInterface::class   => UserRoleService::class,
                UserServiceInterface::class       => UserService::class,
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
                'user' => [__DIR__ . '/../templates/user'],
            ],
        ];
    }
}
