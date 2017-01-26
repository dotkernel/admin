<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:43 PM
 */

namespace Dot\Admin\Form\Admin;

use Zend\InputFilter\InputFilter;

/**
 * Class AdminInputFilter
 * @package Dot\Authentication\Authentication\Form\InputFilter
 */
class AdminInputFilter extends InputFilter
{
    const USERNAME_REQUIRED = 'Username is required and cannot be empty';
    const USERNAME_LENGTH_LIMIT = 'Username must have at least 3 and up to 150 characters';
    const USERNAME_INVALID = 'Username contains invalid characters';
    const USERNAME_TAKEN = 'Username is already taken';

    const EMAIL_REQUIRED = 'Email address is required and cannot be empty';
    const EMAIL_INVALID = 'Email address format is invalid';
    const EMAIL_TAKEN = 'Email address is already registered';

    const FIRSTNAME_LIMIT = 'First name cannot have more than 150 characters';
    const LASTNAME_LIMIT = 'Last name cannot have more than 150 characters';

    const PASSWORD_REQUIRED = 'Password is required and cannot be empty';
    const PASSWORD_LENGTH_LIMIT = 'Password must have at least 4 and up to 150 characters';
    const PASSWORD_VERIFY_REQUIRED = 'Password confirmation is required and cannot be empty';
    const PASSWORD_VERIFY_MISMATCH = 'Password confirmation does not match';

    public function init()
    {
        $this->add([
            'name' => 'id',
            'required' => false,
        ]);

        $this->add([
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
                ],
                [
                    'name' => 'EmsNoRecordExists',
                    'options' => [
                        'key' => 'username',
                        'service' => 'dot-ems.service.admin',
                        'message' => static::USERNAME_TAKEN
                    ],
                ],
            ],
        ]);

        $this->add([
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
                [
                    'name' => 'EmsNoRecordExists',
                    'options' => [
                        'key' => 'email',
                        'service' => 'dot-ems.service.admin',
                        'message' => static::EMAIL_TAKEN,
                    ],
                ],
            ],
        ]);

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
                        'message' => static::FIRSTNAME_LIMIT,
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
                        'message' => static::LASTNAME_LIMIT,
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
