<?php

declare(strict_types=1);

namespace Admin\User\Form;

use Admin\App\Form\AbstractForm;
use Admin\User\InputFilter\CreateUserInputFilter;
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
 * @phpstan-import-type CreateUserDataType from CreateUserInputFilter
 * @extends AbstractForm<CreateUserDataType>
 */
class CreateUserForm extends AbstractForm
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

        $this->inputFilter = new CreateUserInputFilter();
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
        $this
            ->add(
                (new Text('identity'))
                    ->setLabel('Identity')
                    ->setAttribute('required', true)
            )->add(
                (new Password('password'))
                    ->setLabel('Password')
                    ->setAttribute('required', true)
            )->add(
                (new Password('passwordConfirm'))
                    ->setLabel('Password confirm')
                    ->setAttribute('required', true)
            )->add(
                (new Select('status'))
                    ->setLabel('Account status')
                    ->setValueOptions(UserStatusEnum::toArray())
                    ->setAttribute('required', true)
            )->add(
                (new Csrf('userCreateCsrf'))
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
                            ->setAttribute('required', true)
                    )
            );
    }
}
