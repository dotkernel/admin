<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\Enum\AdminStatusEnum;
use Admin\Admin\InputFilter\AdminInputFilter;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

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
                    ['value' => AdminStatusEnum::Active->value, 'label' => AdminStatusEnum::Active->name],
                    ['value' => AdminStatusEnum::Inactive->value, 'label' => AdminStatusEnum::Inactive->name],
                ],
            ],
        ], ['priority' => -30]);

        $this->add(new Csrf('adminManageCsrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'session' => new Container(),
            ],
        ]));
    }

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter): FormInterface
    {
        $this->inputFilter = $inputFilter;
        $this->inputFilter->init();

        return $this;
    }
}
