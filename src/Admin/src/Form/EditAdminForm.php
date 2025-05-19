<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\EditAdminInputFilter;
use Admin\App\Form\AbstractForm;
use Core\Admin\Enum\AdminStatusEnum;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Session\Container;

/**
 * @phpstan-import-type EditAdminDataType from EditAdminInputFilter
 * @extends AbstractForm<EditAdminDataType>
 */
class EditAdminForm extends AbstractForm
{
    /**
     * @param array<non-empty-string, mixed> $options
     */
    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'admin-form');
        $this->setAttribute('class', 'row g-3 needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new EditAdminInputFilter();
        $this->inputFilter->init();
    }

    /**
     * @phpstan-param non-empty-array{
     *     label: non-empty-string,
     *     value: non-empty-string,
     *     selected: bool,
     * }[] $roles
     */
    public function setRoles(array $roles): self
    {
        return $this->add(
            (new MultiCheckbox('roles'))
                ->setLabel('Select at least one role')
                ->setValueOptions($roles)
        );
    }

    public function init(): void
    {
        $this->add(
            (new Password('password'))
                ->setLabel('Password')
        );
        $this->add(
            (new Password('passwordConfirm'))
                ->setLabel('Password confirm')
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
            (new Select('status'))
                ->setLabel('Account status')
                ->setValueOptions(AdminStatusEnum::toArray())
                ->setAttribute('required', true)
        );
        $this->add(
            (new Csrf('adminEditCsrf'))
                ->setOptions([
                    'csrf_options' => ['timeout' => 3600, 'session' => new Container()],
                ])
                ->setAttribute('required', true)
        );
        $this->add(
            (new Submit('submit'))
                ->setAttribute('type', 'submit')
                ->setAttribute('value', 'Save')
                ->setAttribute('class', 'btn btn-sm btn-primary')
        );
    }
}
