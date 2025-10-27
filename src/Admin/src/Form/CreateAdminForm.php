<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\CreateAdminInputFilter;
use Admin\App\Form\AbstractForm;
use Core\Admin\Enum\AdminStatusEnum;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\Session\Container;

/**
 * @phpstan-import-type CreateAdminDataType from CreateAdminInputFilter
 * @phpstan-import-type SelectDataType from AbstractForm
 * @extends AbstractForm<CreateAdminDataType>
 */
class CreateAdminForm extends AbstractForm
{
    /**
     * @param array<non-empty-string, mixed> $options
     * @throws ExceptionInterface
     */
    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'admin-form');
        $this->setAttribute('class', 'row g-3 needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new CreateAdminInputFilter();
        $this->inputFilter->init();
    }

    /**
     * @phpstan-param SelectDataType[] $roles
     * @throws ExceptionInterface
     */
    public function setRoles(array $roles): static
    {
        $checkbox = new MultiCheckbox('roles');
        $checkbox->setLabel('Select at least one role');
        $checkbox->setValueOptions($roles);
        $this->add($checkbox);
        return $this;
    }

    /**
     * @throws ExceptionInterface
     */
    public function init(): void
    {
        $this->add(
            (new Text('identity'))
                ->setLabel('Identity')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Password('password'))
                ->setLabel('Password')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Password('passwordConfirm'))
                ->setLabel('Password confirm')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Text('firstName'))
                ->setLabel('Firstname')
        );
        $this->add(
            (new Text('lastName'))
                ->setLabel('Lastname')
        );

        $select = new Select('status');
        $select->setLabel('Account status');
        $select->setValueOptions(AdminStatusEnum::toArray());
        $select->setAttribute('required', true);
        $this->add($select);

        $this->add(
            (new Csrf('adminCreateCsrf'))
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
