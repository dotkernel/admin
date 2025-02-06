<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\Entity\Admin;
use Admin\Admin\InputFilter\AdminInputFilter;
use Fig\Http\Message\RequestMethodInterface;
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

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;

        $this->add([
            'name'    => 'roles',
            'type'    => 'MultiCheckbox',
            'options' => [
                'label'         => 'Select at least one role:',
                'value_options' => $this->roles,
            ],
        ]);
    }

    public function init(): void
    {
        $this->setAttribute('method', RequestMethodInterface::METHOD_POST);
        $this->setAttribute('class', 'row g-3 needs-validation');
        $this->setAttribute('id', 'admin-form');
        $this->setAttribute('novalidate', 'novalidate');

        $this->add([
            'name'       => 'identity',
            'type'       => 'text',
            'options'    => [
                'label' => 'Identity',
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name'       => 'password',
            'type'       => 'password',
            'options'    => [
                'label'    => 'Password',
                'required' => 'required',
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name'       => 'passwordConfirm',
            'type'       => 'password',
            'options'    => [
                'label' => 'Password Confirm',
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name'    => 'firstName',
            'type'    => 'text',
            'options' => [
                'label' => 'First name',
            ],
        ]);

        $this->add([
            'name'    => 'lastName',
            'type'    => 'text',
            'options' => [
                'label' => 'Last name',
            ],
        ]);

        $this->add([
            'name'       => 'status',
            'type'       => 'select',
            'options'    => [
                'label'         => 'Account Status',
                'value_options' => [
                    ['value' => Admin::STATUS_ACTIVE, 'label' => Admin::STATUS_ACTIVE],
                    ['value' => Admin::STATUS_INACTIVE, 'label' => Admin::STATUS_INACTIVE],
                ],
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        $this->add(new Csrf('adminManageCsrf', [
            'csrf_options' => [
                'timeout' => 3600,
                'session' => new Container(),
            ],
        ]));

        $this->add([
            'name'       => 'submit',
            'type'       => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'class' => 'btn btn-primary',
                'value' => 'Save',
            ],
        ]);
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
