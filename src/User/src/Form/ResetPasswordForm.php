<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\InputFilter\ChangePasswordInputFilter;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class ResetPasswordForm
 * @package Frontend\Admin\Form
 */
class ResetPasswordForm extends Form
{
    protected InputFilter $inputFilter;

    /**
     * RegisterForm constructor.
     * @param null $name
     * @param array $options
     */
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
            'name' => 'password',
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => [
                'placeholder' => 'Password...',
            ],
            'type' => Password::class
        ]);

        $this->add([
            'name' => 'passwordConfirm',
            'options' => [
                'label' => 'Confirm password'
            ],
            'attributes' => [
                'placeholder' => 'Confirm password...',
            ],
            'type' => Password::class
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Change'
            ],
            'type' => Submit::class
        ]);
    }

    /**
     * @return null|InputFilter|InputFilterInterface
     */
    public function getInputFilter(): \Laminas\InputFilter\InputFilterInterface
    {
        return $this->inputFilter;
    }
}
