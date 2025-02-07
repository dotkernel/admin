<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\ChangePasswordInputFilter;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

/** @template-extends Form<FormInterface> */
class ChangePasswordForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'change-password-form');
        $this->setAttribute('class', 'needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new ChangePasswordInputFilter();
        $this->inputFilter->init();
    }

    public function init(): void
    {
        $this->add([
            'name'       => 'currentPassword',
            'type'       => 'Password',
            'options'    => [
                'label' => 'Your current password',
            ],
            'attributes' => [
                'class'    => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name'       => 'password',
            'type'       => 'Password',
            'options'    => [
                'label' => 'New password',
            ],
            'attributes' => [
                'class'    => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name'       => 'passwordConfirm',
            'type'       => 'Password',
            'options'    => [
                'label' => 'New password confirm',
            ],
            'attributes' => [
                'class'    => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Change Password',
                'class' => 'btn btn-primary btn-color',
            ],
        ], ['priority' => -100]);

        $this->add(new Csrf('changePasswordCsrf', [
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
}
