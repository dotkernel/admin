<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/8/2016
 * Time: 10:13 PM
 */

namespace Dot\Admin\Factory\Admin;

use Dot\Admin\Form\Admin\AdminFieldset;
use Dot\Admin\Form\Admin\AdminForm;
use Dot\Admin\Form\Admin\AdminInputFilter;
use Interop\Container\ContainerInterface;

/**
 * Class AdminFormFactory
 * @package Dot\Authentication\Authentication\Factory
 */
class AdminFormFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminForm
     */
    public function __invoke(ContainerInterface $container)
    {
        $filter = $container->get(AdminInputFilter::class);
        $fieldset = $container->get(AdminFieldset::class);

        $form = new AdminForm($fieldset);
        $form->getInputFilter()->add($filter, 'admin');
        $form->init();

        return $form;
    }
}
