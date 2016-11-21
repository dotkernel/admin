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
 * @package Dot\Admin\Form\User
 */
class UserDetailsInputFilter extends InputFilter
{
    public function __construct()
    {

    }

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
                        'message' => 'First name is required and cannot be empty'
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => 'First name is not allowed to have over 150 characters'
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
                        'message' => 'Last name is required and cannot be empty'
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 150,
                        'message' => 'Last name is not allowed to have over 150 characters'
                    ]
                ]
            ],
        ]);
    }
}