<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 11:53 AM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Entity\UserDetailsEntity;
use Dot\Admin\Form\User\UserDetailsFieldset;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

/**
 * Class UserDetailsFieldsetFactory
 * @package Dot\Admin\Factory\User
 */
class UserDetailsFieldsetFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $fieldset = new UserDetailsFieldset();
        $fieldset->setObject(new UserDetailsEntity());
        $fieldset->setHydrator(new ClassMethods(false));
        $fieldset->init();

        return $fieldset;
    }
}