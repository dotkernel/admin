<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:43 PM
 */

namespace Dot\Admin\Admin\Form\InputFilter;

use Dot\Admin\Admin\UIMessages;
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
                        'message' => UIMessages::USERNAME_REQUIRED,
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 150,
                        'message' => UIMessages::USERNAME_LENGTH_LIMIT,
                    ]
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[a-zA-Z0-9-_]+$/',
                        'message' => UIMessages::USERNAME_INVALID_CHARS,
                    ]
                ]
            ],
        ];

        if ($this->usernameValidator) {
            $this->usernameValidator->setMessage(UIMessages::USERNAME_ALREADY_TAKEN);
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
                        'message' => UIMessages::EMAIL_REQUIRED,
                    ]
                ],
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'message' => UIMessages::EMAIL_INVALID,
                    ]
                ],
            ],
        ];

        if ($this->emailValidator) {
            $this->emailValidator->setMessage(UIMessages::EMAIL_ALREADY_REGISTERED);
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
                        'message' => UIMessages::FIRSTNAME_CHARACTER_LIMIT,
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
                        'message' => UIMessages::LASTNAME_CHARACTER_LIMIT,
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
                        'message' => UIMessages::PASSWORD_REQUIRED
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 4,
                        'max' => 150,
                        'message' => UIMessages::PASSWORD_CHARACTER_LIMIT,
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
                        'message' => UIMessages::PASSWORD_VERIFY_REQUIRED,
                    ]
                ],
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'password',
                        'message' => UIMessages::PASSWORD_VERIFY_MISMATCH
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