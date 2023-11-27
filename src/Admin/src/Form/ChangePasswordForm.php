<?php

declare(strict_types=1);

namespace Frontend\Admin\Form;

use Frontend\Admin\InputFilter\ChangePasswordInputFilter;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterInterface;

class ChangePasswordForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

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
                'placeholder' => '',
            ],
        ]);

        $this->add([
            'name'       => 'password',
            'type'       => 'Password',
            'options'    => [
                'label' => 'New password',
            ],
            'attributes' => [
                'placeholder' => '',
            ],
        ]);

        $this->add([
            'name'       => 'passwordConfirm',
            'type'       => 'Password',
            'options'    => [
                'label' => 'New password confirm',
            ],
            'attributes' => [
                'placeholder' => '',
            ],
        ]);

        $this->add([
            'name'    => 'change_password_csrf',
            'type'    => 'csrf',
            'options' => [
                'timeout' => 3600,
                'message' => 'The form CSRF has expired and was refreshed. Please resend the form',
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Change Password',
            ],
        ], ['priority' => -100]);
    }

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}
