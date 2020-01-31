<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Admin\Admin;

use Admin\Admin\Authentication\AuthenticationListener;
use Admin\Admin\Authentication\UnauthorizedListener;
use Admin\Admin\Controller\AdminController;
use Admin\Admin\Entity\AdminEntity;
use Admin\Admin\Entity\RoleEntity;
use Admin\Admin\Factory\AdminHydratorFactory;
use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\AdminFieldset;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Hydrator\AdminHydrator;
use Admin\Admin\Mapper\AdminDbMapper;
use Admin\Admin\Mapper\RoleDbMapper;
use Admin\Admin\Mapper\TokenDbMapper;
use Dot\Mapper\Factory\DbMapperFactory;
use Dot\User\Entity\ConfirmTokenEntity;
use Dot\User\Entity\RememberTokenEntity;
use Dot\User\Entity\ResetTokenEntity;
use Dot\User\Factory\UserDbMapperFactory;
use Dot\User\Factory\UserFieldsetFactory;
use Dot\User\Options\MessagesOptions;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 * @package Admin\Admin
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),

            'templates' => $this->getTemplates(),

            'dot_mapper' => $this->getMappers(),

            'dot_authentication' => $this->getAuthentication(),

            'dot_form' => $this->getForms(),

            'dot_hydrator' => $this->getHydrators(),

            'dot_user' => [
                'user_entity' => AdminEntity::class,
                'role_entity' => RoleEntity::class,

                'default_roles' => ['admin'],

                'route_default' => [
                    'route_name' => 'user',
                    'route_params' => ['action' => 'account']
                ],

                'enable_account_confirmation' => false,

                'login_options' => [
                    'enable_remember' => false,
                    'allowed_status' => [AdminEntity::STATUS_ACTIVE]
                ],
                'register_options' => [
                    'enable_registration' => false,
                ],
                'password_recovery_options' => [
                    'enable_recovery' => false,
                ],
                'template_options' => [
                    'login_template' => 'app::login',
                    'account_template' => 'app::account',
                ],
                'messages_options' => [
                    'messages' => [
                        MessagesOptions::SIGN_OUT_FIRST =>
                            '<a href="/admin/logout">Sign out</a> first in order to access the requested content'
                    ]
                ],

                'event_listeners' => [
                    'controller' => [
                        AdminController::class,
                    ]
                ]
            ]
        ];
    }

    public function getDependencies(): array
    {
        return [

        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app' => [__DIR__ . '/../templates/app']
            ]
        ];
    }

    public function getMappers(): array
    {
        return [
            'mapper_manager' => [
                'factories' => [
                    AdminDbMapper::class => UserDbMapperFactory::class,
                    RoleDbMapper::class => DbMapperFactory::class,
                    TokenDbMapper::class => DbMapperFactory::class,
                ],
                'aliases' => [
                    AdminEntity::class => AdminDbMapper::class,
                    RoleEntity::class => RoleDbMapper::class,

                    ConfirmTokenEntity::class => TokenDbMapper::class,
                    RememberTokenEntity::class => TokenDbMapper::class,
                    ResetTokenEntity::class => TokenDbMapper::class,
                ]
            ],
        ];
    }

    public function getHydrators(): array
    {
        return [
            'hydrator_manager' => [
                'factories' => [
                    AdminHydrator::class => AdminHydratorFactory::class,
                ],
                'aliases' => [
                    'AdminHydrator' => AdminHydrator::class,
                ]
            ]
        ];
    }

    public function getForms(): array
    {
        return [
            'form_manager' => [
                'factories' => [
                    AdminFieldset::class => UserFieldsetFactory::class,
                    AdminForm::class => InvokableFactory::class,
                    AccountForm::class => InvokableFactory::class,
                ],
                'aliases' => [
                    'UserFieldset' => AdminFieldset::class,
                    'AdminFieldset' => AdminFieldset::class,
                    'Admin' => AdminForm::class,
                    'Account' => AccountForm::class,
                ]
            ]
        ];
    }

    public function getAuthentication(): array
    {
        return [
            'web' => [
                'login_route' => [
                    'route_name' => 'login',
                ],

                'logout_route' => [
                    'route_name' => 'logout',
                ],

                'after_logout_route' => [
                    'route_name' => 'login',
                ],
                'after_login_route' => [
                    'route_name' => 'dashboard',
                ],

                'event_listeners' => [
                    [
                        'type' => AuthenticationListener::class,
                        'priority' => 100,
                    ],
                    [
                        'type' => UnauthorizedListener::class,
                        'priority' => 1000,
                    ]
                ]
            ]
        ];
    }
}
