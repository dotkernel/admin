<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 4:52 AM
 */

namespace Dot\Admin\Form\User;

use Zend\InputFilter\InputFilter;
use Zend\Validator\AbstractValidator;

/**
 * Class UserInputFilter
 * @package Dot\Admin\Form\User
 */
class UserInputFilter extends InputFilter
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
        $this->add([
            'name' => 'id',
            'required' => false,
        ]);

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
                        'message' => 'Username must have at least 3 and up to 150 characters',
                    ]
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[a-zA-Z0-9-_]+$/',
                        'message' => 'Username contains some invalid characters',
                    ]
                ]
            ],
        ];

        if ($this->usernameValidator) {
            $this->usernameValidator->setMessage('Username is already taken');
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
                        'message' => 'Email address is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'message' => 'Email address format is invalid',
                    ]
                ],
            ],
        ];

        if ($this->emailValidator) {
            $this->emailValidator->setMessage('Email is already registered');
            $email['validators'][] = $this->emailValidator;
        }

        $this->add($email);

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
                        'message' => 'Password must have at least 4 and up to 150 characters',
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
                        'message' => 'Password verification is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'password',
                        'message' => 'Password verification does not match'
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'role',
        ]);

        $this->add([
            'name' => 'status',
        ]);
    }
}