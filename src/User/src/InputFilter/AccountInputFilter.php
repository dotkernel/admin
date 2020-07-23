<?php

declare(strict_types=1);

namespace Frontend\User\InputFilter;

use Laminas\InputFilter\InputFilter;

/**
 * Class AccountInputFilter
 * @package Frontend\User\InputFilter
 */
class AccountInputFilter extends InputFilter
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
                        'message' => '<b>Identity</b> cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'min' => 3,
                        'max' => 100,
                        'message' => '<b>Identity</b> must have between 3 and 100 characters',
                    ]
                ],
                [
                    'name' => 'Regex',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'pattern' => '/^[a-zA-Z0-9-_.]+$/',
                        'message' => '<b>Identity</b> contains invalid characters',
                    ]
                ],
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
    }
}
