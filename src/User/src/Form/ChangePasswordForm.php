<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\InputFilter\ChangePasswordInputFilter;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class ChangePasswordForm
 * @package Frontend\User\Form
 */
class ChangePasswordForm extends Form
{
    protected InputFilter $inputFilter;

    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new ChangePasswordInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'currentPassword',
            'type' => 'Password',
            'options' => [
                'label' => 'Your current password',
            ],
            'attributes' => [
                'placeholder' => 'Current password...',
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => 'Password',
            'options' => [
                'label' => 'New password',
            ],
            'attributes' => [
                'placeholder' => 'New password...',
            ]
        ]);

        $this->add([
            'name' => 'passwordConfirm',
            'type' => 'Password',
            'options' => [
                'label' => 'New password confirm',
            ],
            'attributes' => [
                'placeholder' => 'New password confirm...',
            ]
        ]);

        $this->add([
            'name' => 'change_password_csrf',
            'type' => 'csrf',
            'options' => [
                'timeout' => 3600,
                'message' => 'The form CSRF has expired and was refreshed. Please resend the form'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Change Password'
            ]
        ], ['priority' => -100]);
    }

    /**
     * @return null|InputFilter|InputFilterInterface
     */
    public function getInputFilter(): \Laminas\InputFilter\InputFilterInterface
    {
        return $this->inputFilter;
    }
}
