<?php
/**
 * @copyright: DotKernel
 * @package: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/20/2016
 * Time: 4:54 AM
 */

namespace Dot\Admin\Form\User;

use Zend\Form\Fieldset;

/**
 * Class UserFieldset
 * @package Dot\Admin\Form\User
 */
class UserFieldset extends Fieldset
{
    /**
     * AdminFieldset constructor.
     * @param string $name
     * @param array $options
     */
    public function __construct($name = 'user_fieldset', array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'username',
            'type' => 'text',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'id' => 'username',
                'placeholder' => 'Username...'
            ]
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'placeholder' => 'Email...'
            ]
        ]);

        $this->add(array(
            'type' => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => array(
                'placeholder' => 'Password',
                //'required' => true,
            ),
        ), ['priority' => -10]);

        $this->add(array(
            'type' => 'password',
            'name' => 'passwordVerify',
            'options' => [
                'label' => 'Confirm Password'
            ],
            'attributes' => array(
                'placeholder' => 'Confirm Password',
                //'required' => true,
            ),
        ), ['priority' => -11]);

        $this->add([
            'name' => 'role',
            'type' => 'select',
            'options' => [
                'label' => 'User Role',
                'value_options' => [
                    ['value' => 'member', 'label' => 'member'],
                    ['value' => 'user', 'label' => 'user'],
                ]
            ],
        ], ['priority' => -20]);

        $this->add([
            'name' => 'status',
            'type' => 'select',
            'options' => [
                'label' => 'Account Status',
                'value_options' => [
                    ['value' => 'pending', 'label' => 'pending'],
                    ['value' => 'active', 'label' => 'active'],
                    ['value' => 'inactive', 'label' => 'inactive'],
                    ['value' => 'deleted', 'label' => 'deleted'],
                ]
            ],
        ], ['priority' => -21]);
    }
}