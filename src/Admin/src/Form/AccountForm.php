<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\EditAccountInputFilter;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

/**
 * @template-extends Form<FormInterface>
 */
class AccountForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'account-form');
        $this->setAttribute('class', 'row g-3 needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new EditAccountInputFilter();
        $this->inputFilter->init();
    }

    public function init(): void
    {
        $this->add(
            (new Text('identity'))
                ->setLabel('Identity')
                ->setAttribute('class', 'form-control form-control-sm')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Text('firstName'))
                ->setLabel('Firstname')
                ->setAttribute('class', 'form-control form-control-sm')
        );
        $this->add(
            (new Text('lastName'))
                ->setLabel('Lastname')
                ->setAttribute('class', 'form-control form-control-sm')
        );
        $this->add(
            (new Csrf('accountCsrf'))
                ->setOptions([
                    'csrf_options' => ['timeout' => 3600, 'session' => new Container()],
                ])
        );
        $this->add(
            (new Submit('submit'))
                ->setAttribute('type', 'submit')
                ->setAttribute('value', 'Update account')
                ->setAttribute('class', 'btn btn-primary btn-color btn-sm')
        );
    }

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}
