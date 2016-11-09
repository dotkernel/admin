<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:43 PM
 */

namespace Dot\Admin\Admin\Form\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\AbstractValidator;

/**
 * Class AdminInputFilter
 * @package Dot\Admin\Admin\Form\InputFilter
 */
class AdminInputFilter extends InputFilter
{
    /** @var  AbstractValidator */
    protected $emailValidator;

    /** @var  AbstractValidator */
    protected $usernameValidator;

    /**
     * AdminInputFilter constructor.
     * @param AbstractValidator|null $emailValidator
     * @param AbstractValidator|null $usernameValidator
     */
    public function __construct($emailValidator = null, $usernameValidator = null)
    {
        $this->usernameValidator = $usernameValidator;
        $this->emailValidator = $emailValidator;
    }

    public function init()
    {
        $username = [
            'name' => 'username',
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => 'Username is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 150,
                        'message' => 'Username must have at least 3 up to 150 characters',
                    ]
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[a-zA-Z0-9-_]+$/',
                        'message' => 'Username has some invalid characters',
                    ]
                ]
            ],
        ];

        if ($this->usernameValidator) {
            $this->usernameValidator->setMessage('Username is already in use');
            $username['validators'][] = $this->usernameValidator;
        }

        $this->add($username);

        $email = [
            'name' => 'email',
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => 'Email is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'message' => 'Email address is invalid',
                    ]
                ],
            ],
        ];

        if ($this->emailValidator) {
            $this->emailValidator->setMessage('Email address is already in use');
            $email['validators'][] = $this->emailValidator;
        }

        $this->add($email);

        $this->add([
            'name' => 'firstName',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => 'First name exceeds the limit of 150 characters'
                    ]
                ]
            ],
        ]);

        $this->add([
            'name' => 'lastName',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => 'Last name exceeds the limit of 150 characters'
                    ]
                ]
            ],
        ]);

        $this->add([
            'name' => 'password',
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => 'Password is required and cannot be empty'
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 4,
                        'max' => 150,
                        'message' => 'Password length must have at least 4 up to 150 characters'
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'passwordVerify',
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => 'Password confirmation is required and cannot be empty'
                    ]
                ],
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'password',
                        'message' => 'Password confirmation does not match'
                    ],
                ],
            ],
        ]);

    }
}