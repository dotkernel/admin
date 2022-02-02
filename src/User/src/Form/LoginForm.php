<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\InputFilter\LoginInputFilter;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class LoginForm
 * @package Frontend\User\Form
 */
class LoginForm extends Form
{
    protected InputFilter $inputFilter;

    /**
     * LoginForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new LoginInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'username',
            'options' => [
                'label' => 'Username'
            ],
            'attributes' => [
                'placeholder' => 'Username',
                'class' => 'form-control'
            ],
            'type' => Text::class
        ]);

        $this->add([
            'name' => 'password',
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => [
                'placeholder' => 'Password',
                'class' => 'form-control'
            ],
            'type' => Password::class
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Log in',
                'class' => 'btn btn-primary btn-block'
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
