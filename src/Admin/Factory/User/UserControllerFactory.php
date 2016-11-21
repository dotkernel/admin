<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/18/2016
 * Time: 9:24 PM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Admin\Form\ConfirmDeleteForm;
use Dot\Admin\Controller\UserController;
use Dot\Admin\Form\User\UserForm;
use Dot\Ems\Service\EntityService;
use Dot\User\Service\PasswordInterface;
use Interop\Container\ContainerInterface;

/**
 * Class UserControllerFactory
 * @package Dot\Admin\User\Factory
 */
class UserControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityService $service */
        $service = $container->get('dot.entity.service.user');
        $userForm = $container->get(UserForm::class);
        $passwordService = $container->get(PasswordInterface::class);

        $confirmDeleteForm = new ConfirmDeleteForm();
        $confirmDeleteForm->init();

        $controller = new UserController($service, $userForm, $confirmDeleteForm);
        $controller->setPasswordService($passwordService);
        $controller->setDebug($container->get('config')['debug']);
        return $controller;
    }
}