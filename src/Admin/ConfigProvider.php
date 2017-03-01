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
use Admin\Admin\Form\AdminFieldset;
use Admin\Admin\Mapper\AdminDbMapper;
use Dot\Admin\Controller\AdminController;
use Dot\User\Controller\UserController;
use Dot\User\Entity\RoleEntity;
use Dot\User\Factory\UserDbMapperFactory;
use Dot\User\Factory\UserFieldsetFactory;

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

            'routes' => $this->getRoutesConfig(),

            'dot_user' => [
                'user_entity' => AdminEntity::class,
                'default_roles' => ['admin'],
                'route_default' => ['route_name' => 'dashboard'],

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
                    'login_template' => 'admin::login'
                ],
                'messages_options' => [
                    'messages' => [

                    ]
                ]
            ]
        ];
    }

    public function getRoutesConfig(): array
    {
        return [
            //change default route paths for user related stuff into admin
            //we will use 'user' for frontend users
            'login_route' => [
                'path' => '/admin/login',
            ],
            'logout_route' => [
                'path' => '/admin/logout',
            ],
            'user_route' => [
                'path' => '/admin[/{action}[/{id:\d+}]]',
                'middleware' => [AdminController::class, UserController::class],
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
                ],
                'aliases' => [
                    AdminEntity::class => AdminDbMapper::class,
                ]
            ],
            'options' => [
                RoleEntity::class => [
                    'mapper' => [
                        'table' => 'admin_role',
                    ]
                ],
            ]
        ];
    }

    public function getFormsConfig(): array
    {
        return [
            'form_manager' => [
                'factories' => [
                    AdminFieldset::class => UserFieldsetFactory::class,
                ],
                'aliases' => [
                    'UserFieldset' => AdminFieldset::class,
                    'AdminFieldset' => AdminFieldset::class,
                ]
            ]
        ];
    }

    public function getAuthenticationConfig(): array
    {
        return [
            'web' => [
                'after_login_route' => ['route_name' => 'dashboard'],

                'event_listeners' => [
                    [
                        'type' => AuthenticationListener::class,
                        'priority' => 100,
                    ]
                ]
            ]
        ];
    }
}
