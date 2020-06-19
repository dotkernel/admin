<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\InputFilter\ProfileDeleteInputFilter;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;

/**
 * Class ProfileDeleteForm
 * @package Frontend\Admin\Form
 */
class ProfileDeleteForm extends Form
{
    /** @var InputFilter $inputFilter */
    protected $inputFilter;

    /**
     * ProfileDeleteForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new ProfileDeleteInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'isDeleted',
            'type' => 'checkbox',
            'attributes' => [
                'class' => 'tooltips',
                'data-toggle' => 'tooltip',
                'title' => 'Delete account',
            ],
            'options' => [
                'label' => 'I want to delete account',
                'use_hidden_element' => true,
                'checked_value' => 'yes',
                'unchecked_value' => 'no',
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Delete'
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
