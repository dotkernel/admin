<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 2:35 PM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Form\User\UserDetailsInputFilter;
use Interop\Container\ContainerInterface;

/**
 * Class UserDetailsInputFilterFactory
 * @package Dot\Admin\Factory\User
 */
class UserDetailsInputFilterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new UserDetailsInputFilter();
        $inputFilter->init();
        return $inputFilter;

    }
}