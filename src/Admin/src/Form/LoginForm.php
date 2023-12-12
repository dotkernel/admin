<?php

declare(strict_types=1);

namespace Frontend\Admin\Form;

use Frontend\Admin\InputFilter\LoginInputFilter;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;

/** @template-extends Form<FormInterface> */
class LoginForm extends Form
{
    protected InputFilterInterface $inputFilter;

    /**
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

    public function init(): void
    {
        $this->add([
            'name'       => 'username',
            'options'    => [
                'label' => 'Username',
            ],
            'attributes' => [
                'placeholder' => 'Username',
                'class'       => 'form-control',
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
                'class'       => 'form-control',
            ],
            'type'       => Password::class,
        ]);

        $this->add([
            'name'       => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Log in',
                'class' => 'btn btn-primary btn-block',
            ],
            'type'       => Submit::class,
        ]);
    }

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}
