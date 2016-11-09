<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:38 PM
 */

namespace Dot\Admin\Admin\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Form;

/**
 * Class AdminForm
 * @package Dot\Admin\Admin\Form
 */
class AdminForm extends Form
{
    /**
     * AdminForm constructor.
     * @param int|null|string $name
     * @param array $options
     */
    public function __construct($name = 'admin_form', array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'username',
            'type' => 'text',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'id' => 'adminUsername',
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
                'label' => 'Admin Role',
                'value_options' => [
                    ['value' => 'superuser', 'label' => 'superuser'],
                    ['value' => 'admin', 'label' => 'admin', 'selected' => true],
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
                    ['value' => 'active', 'label' => 'active', 'selected' => true],
                    ['value' => 'inactive', 'label' => 'inactive'],
                    ['value' => 'deleted', 'label' => 'deleted'],
                ]
            ],
        ]);

        $csrf = new Csrf('admin_add_csrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'message' => 'Add admin form has expired'
            ]
        ]);
        $this->add($csrf);
    }
}