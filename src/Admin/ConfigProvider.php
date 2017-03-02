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
use Admin\Admin\Form\AdminFieldset;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Authentication\UnauthorizedListener;
use Admin\Admin\Mapper\AdminDbMapper;
use Admin\Admin\Mapper\RoleDbMapper;
use Dot\Ems\Factory\DbMapperFactory;
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
                    'login_template' => 'admin::login'
                ],
                'messages_options' => [
                    'messages' => [

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
                ],
                'aliases' => [
                    AdminEntity::class => AdminDbMapper::class,
                    RoleEntity::class => RoleDbMapper::class,
                ]
            ],
        ];
    }

    public function getFormsConfig(): array
    {
        return [
            'form_manager' => [
                'factories' => [
                    AdminFieldset::class => UserFieldsetFactory::class,
                    AdminForm::class => InvokableFactory::class,
                ],
                'aliases' => [
                    'UserFieldset' => AdminFieldset::class,
                    'AdminFieldset' => AdminFieldset::class,
                    'Admin' => AdminForm::class,
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
