<?php

declare(strict_types=1);

namespace Admin\User\Form;

use Admin\App\Form\AbstractForm;
use Admin\User\InputFilter\EditUserInputFilter;
use Core\User\Enum\UserStatusEnum;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Session\Container;

/**
 * @phpstan-import-type EditUserDataType from EditUserInputFilter
 * @phpstan-import-type SelectDataType from AbstractForm
 * @extends AbstractForm<EditUserDataType>
 */
class EditUserForm extends AbstractForm
{
    /**
     * @param array<non-empty-string, mixed> $options
     */
    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'user-form');
        $this->setAttribute('class', 'row g-3 needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new EditUserInputFilter();
        $this->inputFilter->init();
    }

    /**
     * @phpstan-param SelectDataType[] $roles
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
        $this
            ->add(
                (new Password('password'))
                    ->setLabel('Password')
            )->add(
                (new Password('passwordConfirm'))
                    ->setLabel('Password confirm')
            )->add(
                (new Select('status'))
                    ->setLabel('Account status')
                    ->setValueOptions(UserStatusEnum::toArray())
                    ->setAttribute('required', true)
            )->add(
                (new Csrf('userEditCsrf'))
                    ->setOptions([
                        'csrf_options' => ['timeout' => 3600, 'session' => new Container()],
                    ])
                    ->setAttribute('required', true)
            )->add(
                (new Submit('submit'))
                    ->setAttribute('type', 'submit')
                    ->setAttribute('value', 'Save')
                    ->setAttribute('class', 'btn btn-sm btn-primary')
            )->add(
                (new Fieldset('detail'))
                    ->add(
                        (new Text('firstName'))
                            ->setLabel('Firstname')
                    )
                    ->add(
                        (new Text('lastName'))
                            ->setLabel('Lastname')
                    )
                    ->add(
                        (new Email('email'))
                            ->setLabel('Email')
                    )
            );
    }
}
