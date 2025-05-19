<?php

declare(strict_types=1);

namespace Admin\User;

use Admin\User\Delegator\UserRoleDelegator;
use Admin\User\Form\CreateUserForm;
use Admin\User\Form\DeleteUserForm;
use Admin\User\Form\EditUserForm;
use Admin\User\Handler\GetUserCreateFormHandler;
use Admin\User\Handler\GetUserDeleteFormHandler;
use Admin\User\Handler\GetUserEditFormHandler;
use Admin\User\Handler\GetUserListHandler;
use Admin\User\Handler\PostUserAvatarEditHandler;
use Admin\User\Handler\PostUserCreateHandler;
use Admin\User\Handler\PostUserDeleteHandler;
use Admin\User\Handler\PostUserEditHandler;
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
                GetUserCreateFormHandler::class  => AttributedServiceFactory::class,
                GetUserDeleteFormHandler::class  => AttributedServiceFactory::class,
                GetUserEditFormHandler::class    => AttributedServiceFactory::class,
                GetUserListHandler::class        => AttributedServiceFactory::class,
                PostUserAvatarEditHandler::class => AttributedServiceFactory::class,
                PostUserCreateHandler::class     => AttributedServiceFactory::class,
                PostUserDeleteHandler::class     => AttributedServiceFactory::class,
                PostUserEditHandler::class       => AttributedServiceFactory::class,
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
