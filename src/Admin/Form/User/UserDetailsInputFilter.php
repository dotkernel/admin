<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 4:55 AM
 */

namespace Dot\Admin\Form\User;

use Zend\InputFilter\InputFilter;

/**
 * Class UserDetailsInputFilter
 * @package Dot\Authentication\Form\User
 */
class UserDetailsInputFilter extends InputFilter
{
    const FIRSTNAME_REQUIRED = 'First name is required and cannot be empty';
    const FIRSTNAME_LIMIT = 'First name is not allowed to have over 150 characters';
    const LASTNAME_REQUIRED = 'Last name is required and cannot be empty';
    const LASTNAME_LIMIT = 'Last name is not allowed to have over 150 characters';

    const PHONE_INVALID = 'Phone number format is invalid';

    public function init()
    {
        $this->add([
            'name' => 'firstName',
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => static::FIRSTNAME_REQUIRED
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => static::FIRSTNAME_LIMIT
                    ]
                ]
            ],
        ]);

        $this->add([
            'name' => 'lastName',
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => static::LASTNAME_REQUIRED
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => static::LASTNAME_LIMIT
                    ]
                ]
            ],
        ]);

        $this->add([
            'name' => 'address',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [],
        ]);

        $this->add([
            'name' => 'phone',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^\+?\d+$/',
                        'message' => static::PHONE_INVALID
                    ]
                ],
            ],
        ]);
    }
}
