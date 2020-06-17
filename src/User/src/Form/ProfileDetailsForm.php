<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\Fieldset\UserDetailFieldset;
use Frontend\User\InputFilter\RegisterInputFilter;
use Frontend\User\InputFilter\UserDetailInputFilter;
use Laminas\Form\Element\Collection;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;

/**
 * Class ProfileDetailsForm
 * @package Frontend\User\Form
 */
class ProfileDetailsForm extends Form
{
    /** @var InputFilter $inputFilter */
    protected $inputFilter;

    /**
     * ProfileDetailsForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new InputFilter();
        $detailsInputFilter = new UserDetailInputFilter();
        $detailsInputFilter->init();
        $this->inputFilter->add($detailsInputFilter, 'detail');
    }

    public function init()
    {
        parent::init();

        $this->add([
            'type' => UserDetailFieldset::class
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Update'
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
