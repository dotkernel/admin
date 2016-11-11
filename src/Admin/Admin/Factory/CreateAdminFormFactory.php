<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/8/2016
 * Time: 10:13 PM
 */

namespace Dot\Admin\Admin\Factory;


use Dot\Admin\Admin\Form\AdminFieldset;
use Dot\Admin\Admin\Form\CreateAdminForm;
use Dot\Admin\Admin\Form\InputFilter\AdminInputFilter;
use Interop\Container\ContainerInterface;

/**
 * Class AdminFormFactory
 * @package Dot\Admin\Admin\Factory
 */
class CreateAdminFormFactory
{
    /**
     * @param ContainerInterface $container
     * @return CreateAdminForm
     */
    public function __invoke(ContainerInterface $container)
    {
        $filter = $container->get(AdminInputFilter::class);
        $fieldset = $container->get(AdminFieldset::class);

        $form = new CreateAdminForm($fieldset);
        $form->getInputFilter()->add($filter, 'admin');
        $form->init();

        return $form;
    }
}