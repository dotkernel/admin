<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 4:35 PM
 */

declare(strict_types = 1);

namespace Admin\User\Form;

use Dot\User\Form\UserFieldset;

/**
 * Class AdminFieldset
 * @package Admin\User\Form
 */
class AdminFieldset extends UserFieldset
{
    const MESSAGE_FIRST_NAME_EMPTY = '<b>First name</b> is required and cannot be empty';
    const MESSAGE_FIRST_NAME_LIMIT = '<b>First name</b> character limit of 150 exceeded';
    const MESSAGE_LAST_NAME_EMPTY = '<b>Last name</b> is required and cannot be empty';
    const MESSAGE_LAST_NAME_LIMIT = '<b>Last name</b> character limit of 150 exceeded';

    public function __construct()
    {
        parent::__construct('admin');
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'firstName',
            'type' => 'text',
            'options' => [
                'label' => 'First name'
            ],
            'attributes' => [
                'placeholder' => 'First name...'
            ]
        ], ['priority' => -10]);

        $this->add([
            'name' => 'lastName',
            'type' => 'text',
            'options' => [
                'label' => 'Last name'
            ],
            'attributes' => [
                'placeholder' => 'Last name...'
            ]
        ], ['priority' => -11]);

        $this->add([
            'name' => 'status',
            'type' => 'select',
            'options' => [
                'label' => 'Account Status',
                'value_options' => [
                    ['value' => 'active', 'label' => 'active'],
                    ['value' => 'inactive', 'label' => 'inactive'],
                    ['value' => 'deleted', 'label' => 'deleted'],
                ]
            ],
        ], ['priority' => -30]);
    }

    public function getInputFilterSpecification()
    {
        $specs = parent::getInputFilterSpecification();
        $specs['firstName'] = [
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => static::MESSAGE_FIRST_NAME_EMPTY
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => static::MESSAGE_FIRST_NAME_LIMIT,
                    ],
                ]
            ]
        ];
        $specs['lastName'] = [
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => static::MESSAGE_LAST_NAME_EMPTY
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => static::MESSAGE_LAST_NAME_LIMIT,
                    ],
                ]
            ],
        ];

        return $specs;
    }
}
