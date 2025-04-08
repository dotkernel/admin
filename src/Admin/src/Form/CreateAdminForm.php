<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\CreateAdminInputFilter;
use Core\Admin\Enum\AdminStatusEnum;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

/**
 * @template-extends Form<FormInterface>
 */
class CreateAdminForm extends Form
{
    protected InputFilterInterface $inputFilter;

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
        $this->add(
            (new Select('status'))
                ->setLabel('Account status')
                ->setValueOptions(AdminStatusEnum::toArray())
                ->setAttribute('required', true)
        );
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

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter): FormInterface
    {
        $this->inputFilter = $inputFilter;
        $this->inputFilter->init();

        return $this;
    }
}
