<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 1/24/2017
 * Time: 9:19 PM
 */

return [

    'dot_hydrator' => [
        'hydrator_manager' => [
            'factories' => [
                \Dot\User\Entity\UserEntityHydrator::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            ]
        ],
    ],

    'dot_input_filter' => [

        'input_filter_manager' => [
            'factories' => [
                \Dot\Admin\Form\Admin\AdminInputFilter::class =>
                    \Dot\Admin\Factory\Admin\AdminInputFilterFactory::class,
            ],
        ],

    ],

    'dot_form' => [

        'form_manager' => [
            'factories' => [
                \Dot\Admin\Form\Admin\AdminForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
                \Dot\Admin\Form\Admin\AdminFieldset::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            ],
        ],

        'forms' => [

            'admin' => [
                'type' => \Dot\Admin\Form\Admin\AdminForm::class,
                'fieldsets' => [
                    [
                        'spec' => [
                            'name' => 'admin',
                            'type' => \Dot\Admin\Form\Admin\AdminFieldset::class,
                            'hydrator' => \Dot\User\Entity\UserEntityHydrator::class,
                            'object' => \Dot\Admin\Entity\AdminEntity::class,
                            'options' => [
                                'use_as_base_fieldset' => true,
                            ],
                        ],
                    ],
                ],
                'input_filter' => [
                    'admin' => [
                        'type' => \Dot\Admin\Form\Admin\AdminInputFilter::class,
                    ]
                ]
            ],

        ],
    ],
];
