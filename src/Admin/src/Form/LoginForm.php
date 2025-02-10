<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\LoginInputFilter;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

/** @template-extends Form<FormInterface> */
class LoginForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new LoginInputFilter();
        $this->inputFilter->init();
    }

    public function init(): void
    {
        $this->add([
            'name'       => 'username',
            'options'    => [
                'label' => 'Username',
            ],
            'attributes' => [
                'placeholder' => 'Username',
                'class'       => 'form-control form-control-sm',
            ],
            'type'       => Text::class,
        ]);

        $this->add([
            'name'       => 'password',
            'options'    => [
                'label' => 'Password',
            ],
            'attributes' => [
                'placeholder' => 'Password',
                'class'       => 'form-control form-control-sm',
            ],
            'type'       => Password::class,
        ]);

        $this->add([
            'name'       => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Log in',
                'class' => 'btn btn-primary btn-block btn-sm login-button',
            ],
            'type'       => Submit::class,
        ]);

        $this->add(new Csrf('loginCsrf', [
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
