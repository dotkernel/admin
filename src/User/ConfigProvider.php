<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 4:28 AM
 */

declare(strict_types = 1);

namespace Admin\User;

use Dot\Admin\Controller\AdminController;
use Dot\User\Controller\UserController;

/**
 * Class ConfigProvider
 * @package App\User
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),

            'dot_ems' => $this->getMapperConfig(),

            'dot_form' => $this->getFormsConfig(),

            'routes' => $this->getRoutesConfig(),

            'dot_user' => [

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

        ];
    }

    public function getFormsConfig(): array
    {
        return [

        ];
    }
}
