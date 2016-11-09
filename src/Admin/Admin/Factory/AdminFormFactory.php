<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/8/2016
 * Time: 10:13 PM
 */

namespace Dot\Admin\Admin\Factory;


use Dot\Admin\Admin\Form\AdminForm;
use Dot\Admin\Admin\Form\InputFilter\AdminInputFilter;
use Dot\User\Mapper\UserMapperInterface;
use Dot\User\Options\UserOptions;
use Dot\User\Validator\NoRecordsExists;
use Interop\Container\ContainerInterface;

class AdminFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var UserOptions $moduleOptions */
        $options = $container->get(UserOptions::class);

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

        $form = new AdminForm();
        $form->setInputFilter($filter);
        $form->setHydrator($container->get($options->getUserEntityHydrator()));
        $form->init();

        return $form;
    }
}