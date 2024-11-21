<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\AdminDeleteInputFilter;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

/** @template-extends Form<FormInterface> */
class AdminDeleteForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'deleteAdminForm');

        $this->inputFilter = new AdminDeleteInputFilter();
        $this->inputFilter->init();
    }

    public function init(): void
    {
        $this->add([
            'name'       => 'confirmation',
            'type'       => 'checkbox',
            'options'    => [
                'label'           => 'Confirmation',
                'checked_value'   => 'yes',
                'unchecked_value' => 'no',
            ],
            'attributes' => [
                'value' => 'no',
                'id'    => 'confirmation',
                'class' => 'form-check-input',
            ],
        ]);

        $this->add([
            'name'       => 'close',
            'type'       => 'button',
            'options'    => [
                'label' => 'Close',
            ],
            'attributes' => [
                'class'           => 'btn btn-default',
                'data-bs-dismiss' => 'modal',
                'role'            => 'button',
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => 'submit',
            'attributes' => [
                'class' => 'btn btn-danger',
                'id'    => 'modalDeleteBtn',
                'value' => 'Delete',
            ],
        ]);

        $this->add(new Csrf('adminDeleteCsrf', [
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
