<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\EditAccountInputFilter;
use Admin\App\Form\AbstractForm;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\Session\Container;

/**
 * @phpstan-import-type EditAccountDataType from EditAccountInputFilter
 * @extends AbstractForm<EditAccountDataType>
 */
class AccountForm extends AbstractForm
{
    /**
     * @param array<non-empty-string, mixed> $options
     * @throws ExceptionInterface
     */
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

    /**
     * @throws ExceptionInterface
     */
    public function init(): void
    {
        $this->add(
            (new Text('identity'))
                ->setLabel('Identity')
                ->setAttribute('readonly', true)
                ->setAttribute('required', true)
                ->setAttribute('class', 'form-control form-control-sm bgc-grey-200')
        );
        $this->add(
            (new Text('firstName'))
                ->setLabel('Firstname')
        );
        $this->add(
            (new Text('lastName'))
                ->setLabel('Lastname')
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
}
