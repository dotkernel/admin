<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\InputFilter\AccountInputFilter;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class AccountForm
 * @package Frontend\User\Form
 */
class AccountForm extends Form
{
    protected InputFilter $inputFilter;

    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new AccountInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        $this->add([
            'name' => 'identity',
            'type' => 'text',
            'options' => [
                'label' => 'Identity'
            ],
            'attributes' => [
                'placeholder' => 'Identity...'
            ]
        ], ['priority' => -9]);

        $this->add([
            'name' => 'firstName',
            'type' => 'text',
            'options' => [
                'label' => 'First name'
            ],
            'attributes' => [
                'placeholder' => 'First name...'
            ]
        ], ['priority' => -10]);

        $this->add([
            'name' => 'lastName',
            'type' => 'text',
            'options' => [
                'label' => 'Last name'
            ],
            'attributes' => [
                'placeholder' => 'Last name...'
            ]
        ], ['priority' => -11]);

        $this->add([
            'name' => 'account_csrf',
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
                'value' => 'Update account'
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
