<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/10/2016
 * Time: 8:00 PM
 */

namespace Dot\Admin\Form\Admin;

use Zend\Form\Fieldset;

/**
 * Class AdminFieldset
 * @package Dot\Authentication\Authentication\Form
 */
class AdminFieldset extends Fieldset
{
    /**
     * AdminFieldset constructor.
     * @param string $name
     * @param array $options
     */
    public function __construct($name = 'admin_fieldset', array $options = [])
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

        $this->add([
            'name' => 'firstName',
            'type' => 'text',
            'options' => [
                'label' => 'First name',
            ],
            'attributes' => [
                'placeholder' => 'First name...'
            ]
        ]);

        $this->add([
            'name' => 'lastName',
            'type' => 'text',
            'options' => [
                'label' => 'Last name',
            ],
            'attributes' => [
                'placeholder' => 'Last name...'
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
        ));

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
        ));

        $this->add([
            'name' => 'role',
            'type' => 'select',
            'options' => [
                'label' => 'Authentication Role',
                'value_options' => [
                    ['value' => 'superuser', 'label' => 'superuser'],
                    ['value' => 'admin', 'label' => 'admin'],
                ]
            ],
        ]);

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
        ]);
    }
}
