<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/10/2016
 * Time: 9:08 PM
 */

namespace Dot\Admin\Factory\Admin;

use Dot\Admin\Form\Admin\AdminInputFilter;
use Dot\Ems\Validator\NoRecordsExists;
use Interop\Container\ContainerInterface;

/**
 * Class AdminInputFilterFactory
 * @package Dot\Authentication\Authentication\Factory
 */
class AdminInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminInputFilter
     */
    public function __invoke(ContainerInterface $container)
    {
        $service = $container->get('dot-ems.service.admin');
        $filter = new AdminInputFilter(
            new NoRecordsExists([
                'service' => $service,
                'key' => 'email'
            ]),
            new NoRecordsExists([
                'service' => $service,
                'key' => 'username'
            ])
        );

        return $filter;
    }
}
