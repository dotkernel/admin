<?php

declare(strict_types=1);

namespace Frontend\Admin\Form;

use Frontend\Admin\InputFilter\AccountInputFilter;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterInterface;

class AccountForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new AccountInputFilter();
        $this->inputFilter->init();
    }

    public function init(): void
    {
        $this->add([
            'name'       => 'identity',
            'type'       => 'text',
            'options'    => [
                'label' => 'Identity',
            ],
            'attributes' => [
                'placeholder' => 'Identity...',
            ],
        ], ['priority' => -9]);

        $this->add([
            'name'       => 'firstName',
            'type'       => 'text',
            'options'    => [
                'label' => 'First name',
            ],
            'attributes' => [
                'placeholder' => 'First name...',
            ],
        ], ['priority' => -10]);

        $this->add([
            'name'       => 'lastName',
            'type'       => 'text',
            'options'    => [
                'label' => 'Last name',
            ],
            'attributes' => [
                'placeholder' => 'Last name...',
            ],
        ], ['priority' => -11]);

        $this->add([
            'name'    => 'account_csrf',
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
                'value' => 'Update account',
            ],
        ], ['priority' => -100]);
    }

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}
