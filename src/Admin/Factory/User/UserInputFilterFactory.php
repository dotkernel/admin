<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 11:59 AM
 */

namespace Dot\Admin\Factory\User;

use Dot\Admin\Form\User\UserInputFilter;
use Dot\Admin\Service\UserService;
use Dot\Ems\Validator\NoRecordsExists;
use Interop\Container\ContainerInterface;

/**
 * Class UserInputFilterFactory
 * @package Dot\Authentication\Factory\User
 */
class UserInputFilterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $service = $container->get(UserService::class);
        $inputFilter = new UserInputFilter(
            new NoRecordsExists([
                'service' => $service,
                'key' => 'email'
            ]),
            new NoRecordsExists([
                'service' => $service,
                'key' => 'username'
            ])
        );
        $inputFilter->init();

        return $inputFilter;
    }
}