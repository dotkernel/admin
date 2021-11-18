<?php

declare(strict_types=1);

namespace Frontend\User\InputFilter;

use Frontend\User\Entity\User;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\InArray;

/**
 * Class UserInputFilter
 * @package Frontend\User\InputFilter
 */
class UserInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'identity',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>identity</b> is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 150,
                        'message' => '<b>Username</b> must have between 3 and 150 characters',
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Password</b> is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 8,
                        'max' => 150,
                        'message' => '<b>Password</b> must have between 8 and 150 characters',
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'passwordConfirm',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Confirm Password</b> is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 8,
                        'max' => 150,
                        'message' => '<b>Confirm Password</b> must have between 8 and 150 characters',
                    ]
                ],
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'password',
                        'message' => '<b>Password confirm</b> does not match',
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'firstName',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => '<b>FirstName</b> must max 150 characters',
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'lastName',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => '<b>Last Name</b> must max 150 characters',
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'status',
            'required' => true,
            'filters' => [],
            'validators' => [
                [
                    'name' => InArray::class,
                    'options' => [
                        'haystack' => [
                            User::STATUS_ACTIVE,
                            User::STATUS_PENDING
                        ]
                    ],
                ]
            ]
        ]);

        $this->add([
            'name' => 'roles',
            'required' => true,
            'filters' => [],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => 'Please select at least one role',
                    ]
                ],
            ]
        ]);
    }
}
