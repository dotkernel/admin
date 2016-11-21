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
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

/**
 * Class UserFieldsetFactory
 * @package Dot\Admin\Factory\User
 */
class UserFieldsetFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $fieldset = new UserFieldset();

        $fieldset->setObject(new UserEntity());
        $fieldset->setHydrator(new ClassMethods(false));
        $fieldset->init();

        return $fieldset;
    }
}