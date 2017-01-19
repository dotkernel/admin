<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 11:49 AM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Form\User\UserDetailsFieldset;
use Dot\Admin\Form\User\UserDetailsInputFilter;
use Dot\Admin\Form\User\UserFieldset;
use Dot\Admin\Form\User\UserForm;
use Dot\Admin\Form\User\UserInputFilter;
use Interop\Container\ContainerInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class UserFormFactory
 * @package Dot\Authentication\Factory\User
 */
class UserFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $userDetailsFieldset = $container->get(UserDetailsFieldset::class);
        $userFieldset = $container->get(UserFieldset::class);

        /** @var InputFilter $userInputFilter */
        $userInputFilter = $container->get(UserInputFilter::class);
        $userDetailsInputFilter = $container->get(UserDetailsInputFilter::class);

        $userInputFilter->add($userDetailsInputFilter, 'details');

        $form = new UserForm($userFieldset, $userDetailsFieldset);
        $form->getInputFilter()->add($userInputFilter, 'user');
        $form->init();

        return $form;
    }
}
