<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\InputFilter\RequestResetPasswordInputFilter;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;

/**
 * Class RequestResetPasswordForm
 * @package Frontend\User\Form
 */
class RequestResetPasswordForm extends Form
{
    /** @var InputFilter $inputFilter */
    protected $inputFilter;

    /**
     * LoginForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new RequestResetPasswordInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'identity',
            'options' => [
                'label' => 'Email address'
            ],
            'attributes' => [
                'placeholder' => 'Email address',
            ],
            'type' => Email::class
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Request'
            ],
            'type' => Submit::class
        ]);
    }

    /**
     * @return null|InputFilter|\Laminas\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}
