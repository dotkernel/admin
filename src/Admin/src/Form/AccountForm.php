<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\AccountInputFilter;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

/** @template-extends Form<FormInterface> */
class AccountForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'account-form');
        $this->setAttribute('class', 'needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new AccountInputFilter();
        $this->inputFilter->init();
    }

    public function init(): void
    {
        $this->add([
            'name'             => 'identity',
            'type'             => 'text',
            'options'          => [
                'label' => 'Identity',
            ],
            'label_attributes' => [
                'test' => 'da',
            ],
            'attributes'       => [
                'placeholder' => 'Identity...',
                'class'       => 'form-control form-control-sm',
                'required'    => 'required',
            ],
        ]);

        $this->add([
            'name'       => 'firstName',
            'type'       => 'text',
            'options'    => [
                'label' => 'First name',
            ],
            'attributes' => [
                'placeholder' => 'First name...',
                'class'       => 'form-control form-control-sm',
                'required'    => 'required',
            ],
        ]);

        $this->add([
            'name'       => 'lastName',
            'type'       => 'text',
            'options'    => [
                'label' => 'Last name',
            ],
            'attributes' => [
                'placeholder' => 'Last name...',
                'class'       => 'form-control form-control-sm',
                'required'    => 'required',
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => 'submit',
            'attributes' => [
                'type'  => 'submit',
                'value' => 'Update account',
                'class' => 'btn btn-primary btn-color btn-sm',
            ],
        ]);

        $this->add(new Csrf('accountCsrf', [
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
