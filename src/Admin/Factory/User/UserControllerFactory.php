<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/18/2016
 * Time: 9:24 PM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Controller\UserController;
use Dot\Admin\Form\ConfirmDeleteForm;
use Dot\Admin\Form\User\UserForm;
use Dot\Admin\Service\EntityServiceInterface;
use Interop\Container\ContainerInterface;

/**
 * Class UserControllerFactory
 * @package Dot\Authentication\User\Factory
 */
class UserControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityServiceInterface $service */
        $service = $container->get('dot-ems.service.user');
        $userForm = $container->get(UserForm::class);

        $confirmDeleteForm = new ConfirmDeleteForm();
        $confirmDeleteForm->init();

        $controller = new UserController($service, $userForm, $confirmDeleteForm);
        $controller->setDebug($container->get('config')['debug']);

        return $controller;
    }
}