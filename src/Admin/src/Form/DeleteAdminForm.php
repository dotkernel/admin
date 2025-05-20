<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\DeleteAdminInputFilter;
use Admin\App\Form\AbstractForm;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Submit;
use Laminas\Session\Container;

/**
 * @phpstan-import-type DeleteAdminDataType from DeleteAdminInputFilter
 * @extends AbstractForm<DeleteAdminDataType>
 */
class DeleteAdminForm extends AbstractForm
{
    /**
     * @param array<non-empty-string, mixed> $options
     */
    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'delete-admin-form');
        $this->setAttribute('class', 'needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new DeleteAdminInputFilter();
        $this->inputFilter->init();
    }

    public function init(): void
    {
        $this->add(
            (new Checkbox('confirmation'))
                ->setCheckedValue('yes')
                ->setUncheckedValue('no')
                ->setAttribute('id', 'confirmation')
                ->setAttribute('class', 'form-check-input')
                ->setAttribute('required', true)
                ->setValue('no')
        );
        $this->add(
            (new Csrf('adminDeleteCsrf'))
                ->setOptions([
                    'csrf_options' => ['timeout' => 3600, 'session' => new Container()],
                ])
                ->setAttribute('required', true)
        );
        $this->add(
            (new Submit('submit'))
                ->setAttribute('type', 'submit')
                ->setAttribute('value', 'Delete')
                ->setAttribute('class', 'btn btn-sm btn-danger')
        );
    }
}
