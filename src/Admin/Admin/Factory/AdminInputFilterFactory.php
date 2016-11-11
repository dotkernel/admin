<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/10/2016
 * Time: 9:08 PM
 */

namespace Dot\Admin\Admin\Factory;

use Dot\Admin\Admin\Form\InputFilter\AdminInputFilter;
use Dot\User\Mapper\UserMapperInterface;
use Dot\User\Validator\NoRecordsExists;
use Interop\Container\ContainerInterface;

/**
 * Class AdminInputFilterFactory
 * @package Dot\Admin\Admin\Factory
 */
class AdminInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminInputFilter
     */
    public function __invoke(ContainerInterface $container)
    {
        $filter = new AdminInputFilter(
            new NoRecordsExists([
                'mapper' => $container->get(UserMapperInterface::class),
                'key' => 'email'
            ]),
            new NoRecordsExists([
                'mapper' => $container->get(UserMapperInterface::class),
                'key' => 'username'
            ])
        );
        $filter->init();
        return $filter;
    }
}