<?php

declare(strict_types=1);

namespace Frontend\Admin\Form;

use Frontend\Admin\Entity\Admin;
use Frontend\Admin\InputFilter\AdminInputFilter;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/** @template-extends Form<FormInterface> */
class AdminForm extends Form
{
    protected InputFilterInterface $inputFilter;
    protected array $roles = [];

    public function __construct(?string $name = null, array $options = [])
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
            'name'    => 'roles',
            'type'    => 'MultiCheckbox',
            'options' => [
                'label'         => 'Roles',
                'value_options' => $roles,
            ],
        ]);
    }

    public function init(): void
    {
        $this->add([
            'name'       => 'identity',
            'type'       => 'text',
            'options'    => [
                'label' => 'Identity',
            ],
            'attributes' => [
                'placeholder' => '',
            ],
        ], ['priority' => -9]);

        $this->add([
            'name'       => 'password',
            'type'       => 'password',
            'options'    => [
                'label' => 'Password',
            ],
            'attributes' => [
                'placeholder' => '',
            ],
        ], ['priority' => -9]);

        $this->add([
            'name'       => 'passwordConfirm',
            'type'       => 'password',
            'options'    => [
                'label' => 'Password Confirm',
            ],
            'attributes' => [
                'placeholder' => '',
            ],
        ], ['priority' => -9]);

        $this->add([
            'name'       => 'firstName',
            'type'       => 'text',
            'options'    => [
                'label' => 'First name',
            ],
            'attributes' => [
                'placeholder' => '',
            ],
        ], ['priority' => -10]);

        $this->add([
            'name'       => 'lastName',
            'type'       => 'text',
            'options'    => [
                'label' => 'Last name',
            ],
            'attributes' => [
                'placeholder' => '',
            ],
        ], ['priority' => -11]);

        $this->add([
            'name'    => 'status',
            'type'    => 'select',
            'options' => [
                'label'         => 'Account Status',
                'value_options' => [
                    ['value' => Admin::STATUS_ACTIVE, 'label' => Admin::STATUS_ACTIVE],
                    ['value' => Admin::STATUS_INACTIVE, 'label' => Admin::STATUS_INACTIVE],
                ],
            ],
        ], ['priority' => -30]);
    }

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }

    public function setDifferentInputFilter(InputFilter $inputFilter): void
    {
        $this->inputFilter = $inputFilter;
        $this->inputFilter->init();
    }
}
