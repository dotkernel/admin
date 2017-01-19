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
 * @package Dot\Authentication\Form\User
 */
class UserInputFilter extends InputFilter
{
    const USERNAME_REQUIRED = 'Username is required and cannot be empty';
    const USERNAME_LENGTH_LIMIT = 'Username must have at least 3 and up to 150 characters';
    const USERNAME_INVALID = 'Username contains invalid characters';
    const USERNAME_TAKEN = 'Username is already taken';

    const EMAIL_REQUIRED = 'Email address is required and cannot be empty';
    const EMAIL_INVALID = 'Email address format is invalid';
    const EMAIL_TAKEN = 'Email address is already registered';

    const PASSWORD_REQUIRED = 'Password is required and cannot be empty';
    const PASSWORD_LENGTH_LIMIT = 'Password must have at least 4 and up to 150 characters';
    const PASSWORD_VERIFY_REQUIRED = 'Password confirmation is required and cannot be empty';
    const PASSWORD_VERIFY_MISMATCH = 'Password confirmation does not match';

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
                        'message' => static::USERNAME_REQUIRED,
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 150,
                        'message' => static::USERNAME_LENGTH_LIMIT,
                    ]
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[a-zA-Z0-9-_]+$/',
                        'message' => static::USERNAME_INVALID,
                    ]
                ]
            ],
        ];

        if ($this->usernameValidator) {
            $this->usernameValidator->setMessage(static::USERNAME_TAKEN);
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
                        'message' => static::EMAIL_REQUIRED,
                    ]
                ],
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'message' => static::EMAIL_INVALID,
                    ]
                ],
            ],
        ];

        if ($this->emailValidator) {
            $this->emailValidator->setMessage(static::EMAIL_TAKEN);
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
                        'message' => static::PASSWORD_REQUIRED
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 4,
                        'max' => 150,
                        'message' => static::PASSWORD_LENGTH_LIMIT,
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
                        'message' => static::PASSWORD_VERIFY_REQUIRED,
                    ]
                ],
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'password',
                        'message' => static::PASSWORD_VERIFY_MISMATCH
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
