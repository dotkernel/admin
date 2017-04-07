<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Admin\User\Form;

use Admin\User\Entity\UserDetailsEntity;
use Dot\Hydrator\ClassMethodsCamelCase;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Class UserDetailsFieldset
 * @package Admin\User\Fieldset
 */
class UserDetailsFieldset extends Fieldset implements InputFilterProviderInterface
{
    const MESSAGE_FIRST_NAME_EMPTY = '<b>First name</b> is required and cannot be empty';
    const MESSAGE_FIRST_NAME_LIMIT = '<b>First name</b> character limit of 150 exceeded';
    const MESSAGE_LAST_NAME_EMPTY = '<b>Last name</b> is required and cannot be empty';
    const MESSAGE_LAST_NAME_LIMIT = '<b>Last name</b> character limit of 150 exceeded';

    const PHONE_INVALID = '<b>Phone</b> number is invalid';
    const PHONE_LIMIT = '<b>Phone</b> number character limit exceeded';

    /**
     * UserDetailsFieldset constructor.
     */
    public function __construct()
    {
        parent::__construct('details');
        $this->setObject(new UserDetailsEntity());
        $this->setHydrator(new ClassMethodsCamelCase());
    }

    public function init()
    {
        $this->add([
            'name' => 'firstName',
            'type' => 'text',
            'options' => [
                'label' => 'First name'
            ],
            'attributes' => [
                'placeholder' => 'First name...'
            ]
        ]);
        $this->add([
            'name' => 'lastName',
            'type' => 'text',
            'options' => [
                'label' => 'Last name'
            ],
            'attributes' => [
                'placeholder' => 'Last name...'
            ]
        ]);
        $this->add([
            'name' => 'phone',
            'type' => 'text',
            'options' => [
                'label' => 'Phone'
            ],
            'attributes' => [
                'placeholder' => 'Phone...'
            ]
        ]);
        $this->add([
            'name' => 'address',
            'type' => 'text',
            'options' => [
                'label' => 'Address'
            ],
            'attributes' => [
                'placeholder' => 'Address...'
            ]
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'firstName' => [
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
            ],
            'lastName' => [
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
            ],
            'phone' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StringTrim'],
                    ['name' => 'ToNull']
                ],
                'validators' => [
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^\+?\d+$/',
                            'message' => static::PHONE_INVALID
                        ]
                    ],
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'max' => 150,
                            'message' => static::PHONE_LIMIT,
                        ],
                    ]
                ],
            ],
            'address' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StringTrim'],
                    ['name' => 'ToNull']
                ],
                'validators' => [

                ],
            ],
        ];
    }
}
