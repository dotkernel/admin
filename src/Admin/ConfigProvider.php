<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 4:28 AM
 */

declare(strict_types = 1);

namespace Admin\Admin;

use Admin\Admin\Authentication\AuthenticationListener;
use Admin\Admin\Entity\AdminEntity;
use Admin\Admin\Entity\RoleEntity;
use Admin\Admin\Factory\AdminHydratorFactory;
use Admin\Admin\Form\AccountForm;
use Admin\Admin\Form\AdminFieldset;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Authentication\UnauthorizedListener;
use Admin\Admin\Hydrator\AdminHydrator;
use Admin\Admin\Mapper\AdminDbMapper;
use Admin\Admin\Mapper\RoleDbMapper;
use Admin\Admin\Mapper\TokenDbMapper;
use Admin\App\Controller\AdminController;
use Dot\Mapper\Factory\DbMapperFactory;
use Dot\User\Entity\ConfirmTokenEntity;
use Dot\User\Entity\RememberTokenEntity;
use Dot\User\Entity\ResetTokenEntity;
use Dot\User\Factory\UserDbMapperFactory;
use Dot\User\Factory\UserFieldsetFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 * @package App\Admin
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),

            'dot_ems' => $this->getMapperConfig(),

            'dot_authentication' => $this->getAuthenticationConfig(),

            'dot_form' => $this->getFormsConfig(),

            'dot_hydrator' => $this->getHydratorsConfig(),

            'dot_user' => [
                'user_entity' => AdminEntity::class,
                'role_entity' => RoleEntity::class,

                'default_roles' => ['admin'],
                'route_default' => ['route_name' => 'dashboard', 'route_params' => ['action' => '']],

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
                    'login_template' => 'admin::login',
                    'account_template' => 'admin::account',
                ],
                'messages_options' => [
                    'messages' => [

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

    public function getDependenciesConfig(): array
    {
        return [

        ];
    }

    public function getMapperConfig(): array
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

    public function getHydratorsConfig(): array
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

    public function getFormsConfig(): array
    {
        return [
            'form_manager' => [
                'factories' => [
                    AdminFieldset::class => UserFieldsetFactory::class,
                    AdminForm::class => InvokableFactory::class,
                    AccountForm::class => InvokableFactory::class,
                    //ChangePasswordForm::class => InvokableFactory::class,
                ],
                'aliases' => [
                    'UserFieldset' => AdminFieldset::class,
                    'AdminFieldset' => AdminFieldset::class,
                    'Admin' => AdminForm::class,
                    'Account' => AccountForm::class,
                    //'ChangePassword' => ChangePasswordForm::class,
                ]
            ]
        ];
    }

    public function getAuthenticationConfig(): array
    {
        return [
            'web' => [
                'after_login_route' => ['route_name' => 'dashboard', 'route_params' => ['action' => '']],

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
