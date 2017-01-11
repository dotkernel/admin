<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 11:53 AM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Entity\UserEntity;
use Dot\Admin\Form\User\UserFieldset;
use Dot\User\Entity\UserEntityHydrator;
use Interop\Container\ContainerInterface;

/**
 * Class UserFieldsetFactory
 * @package Dot\Authentication\Factory\User
 */
class UserFieldsetFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $fieldset = new UserFieldset();

        $fieldset->setObject(new UserEntity());
        $fieldset->setHydrator(new UserEntityHydrator());
        $fieldset->init();

        return $fieldset;
    }
}
