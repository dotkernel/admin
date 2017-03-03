<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/1/2017
 * Time: 5:07 PM
 */

declare(strict_types = 1);

namespace Admin\App;

use Admin\App\Controller\AdminController;
use Admin\App\Controller\DashboardController;
use Admin\App\Controller\UserController;
use Admin\App\Form\ConfirmDeleteForm;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 * @package Admin\App
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),

            'dot_form' => $this->getFormsConfig(),

            'routes' => $this->getRoutesConfig(),
        ];
    }

    public function getDependenciesConfig(): array
    {
        return [

        ];
    }

    public function getFormsConfig(): array
    {
        return [
            'form_manager' => [
                'factories' => [
                    ConfirmDeleteForm::class => InvokableFactory::class,
                ],
                'aliases' => [
                    'ConfirmDelete' => ConfirmDeleteForm::class,
                ]
            ]
        ];
    }

    public function getRoutesConfig(): array
    {
        return [
            [
                'name' => 'dashboard',
                'path' => '/dashboard[/[{action}]]',
                'middleware' => DashboardController::class,
            ],
            [
                // there is already a route named `user` from dot-user package,
                // so we use a diff one for the frontend user management
                'name' => 'f_user',
                'path' => '/user[/{action}[/{id:\d+}]]',
                'middleware' => UserController::class,
            ],

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
}
