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
                \Dot\User\Entity\UserEntityHydrator::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,
            ]
        ],
    ],

    'dot_input_filter' => [
        'input_filter_manager' => [
            'factories' => [
                \Dot\Admin\Form\Admin\AdminInputFilter::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,

                \Dot\Admin\Form\User\UserInputFilter::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,

                \Dot\Admin\Form\User\UserDetailsInputFilter::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class
            ],
        ],
    ],

    'dot_form' => [
        'form_manager' => [
            'factories' => [
                \Dot\Admin\Form\Admin\AdminForm::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,

                \Dot\Admin\Form\Admin\AdminFieldset::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,

                \Dot\Admin\Form\User\UserForm::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,

                \Dot\Admin\Form\User\UserFieldset::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,

                \Dot\Admin\Form\User\UserDetailsFieldset::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,

                \Dot\Admin\Form\ConfirmDeleteForm::class =>
                    \Zend\ServiceManager\Factory\InvokableFactory::class,
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

                            'object' => \Dot\Admin\Entity\Admin\AdminEntity::class,
                            'hydrator' => \Dot\User\Entity\UserEntityHydrator::class,

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

            'user' => [
                'type' => \Dot\Admin\Form\User\UserForm::class,
                'fieldsets' => [
                    [
                        'spec' => [
                            'name' => 'user',
                            'type' => \Dot\Admin\Form\User\UserFieldset::class,

                            'object' => \Dot\Admin\Entity\User\UserEntity::class,
                            'hydrator' => \Dot\User\Entity\UserEntityHydrator::class,

                            'options' => [
                                'use_as_base_fieldset' => true,
                            ],

                            'fieldsets' => [
                                [
                                    'spec' => [
                                        'name' => 'details',
                                        'type' => \Dot\Admin\Form\User\UserDetailsFieldset::class,

                                        'object' => \Dot\Admin\Entity\User\UserDetailsEntity::class,
                                        'hydrator' => \Dot\Hydrator\ClassMethodsCamelCase::class,
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
                'input_filter' => [
                    'user' => [
                        'type' => \Dot\Admin\Form\User\UserInputFilter::class,
                        'details' => [
                            'type' => \Dot\Admin\Form\User\UserDetailsInputFilter::class,
                        ]
                    ]
                ]
            ],

            'confirm_delete' => [
                'type' => \Dot\Admin\Form\ConfirmDeleteForm::class,
            ],


        ],
    ],
];
