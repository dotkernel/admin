<?php

declare(strict_types=1);

namespace Frontend\Admin\Form;

use Frontend\Admin\InputFilter\AdminDeleteInputFilter;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;

/** @template-extends Form<FormInterface> */
class AdminDeleteForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

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
    }

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter): void
    {
        $this->inputFilter = $inputFilter;
        $this->inputFilter->init();
    }
}
