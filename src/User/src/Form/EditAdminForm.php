<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\Entity\Admin;
use Frontend\User\InputFilter\AdminInputFilter;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class EditEditAdminForm
 * @package Frontend\User\Form
 */
class EditAdminForm extends Form
{
    protected InputFilter $inputFilter;

    protected array $roles = [];

    /**
     * RegisterForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new AdminInputFilter();
        $this->inputFilter->init();
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;

        $this->add([
            'name' => 'roleUuid',
            'type' => 'select',
            'options' => [
                'label' => 'Role',
                'value_options' => $roles
            ]
        ]);
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'identity',
            'type' => 'text',
            'options' => [
                'label' => 'Identity'
            ],
            'attributes' => [
                'placeholder' => 'Identity...'
            ]
        ], ['priority' => -9]);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => [
                'placeholder' => 'Password...'
            ]
        ], ['priority' => -9]);

        $this->add([
            'name' => 'passwordConfirm',
            'type' => 'password',
            'options' => [
                'label' => 'Password Confirm'
            ],
            'attributes' => [
                'placeholder' => 'Password Confirm...'
            ]
        ], ['priority' => -9]);

        $this->add([
            'name' => 'firstName',
            'type' => 'text',
            'options' => [
                'label' => 'First name'
            ],
            'attributes' => [
                'placeholder' => 'First name...'
            ]
        ], ['priority' => -10]);

        $this->add([
            'name' => 'lastName',
            'type' => 'text',
            'options' => [
                'label' => 'Last name'
            ],
            'attributes' => [
                'placeholder' => 'Last name...'
            ]
        ], ['priority' => -11]);

        $this->add([
            'name' => 'status',
            'type' => 'select',
            'options' => [
                'label' => 'Account Status',
                'value_options' => [
                    ['value' => Admin::STATUS_ACTIVE, 'label' => Admin::STATUS_ACTIVE],
                    ['value' => Admin::STATUS_INACTIVE, 'label' => Admin::STATUS_INACTIVE]
                ]
            ],
        ], ['priority' => -30]);
    }

    /**
     * @return InputFilter|InputFilterInterface|null
     */
    public function getInputFilter(): \Laminas\InputFilter\InputFilterInterface
    {
        return $this->inputFilter;
    }
}
