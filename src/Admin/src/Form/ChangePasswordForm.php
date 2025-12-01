<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\ChangePasswordInputFilter;
use Admin\App\Form\AbstractForm;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

/**
 * @phpstan-import-type ChangePasswordDataType from ChangePasswordInputFilter
 * @extends AbstractForm<ChangePasswordDataType>
 */
class ChangePasswordForm extends AbstractForm
{
    /**
     * @param array<non-empty-string, mixed> $options
     * @throws ExceptionInterface
     */
    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'change-password-form');
        $this->setAttribute('class', 'row g-3 needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new ChangePasswordInputFilter();
        $this->inputFilter->init();
    }

    /**
     * @throws ExceptionInterface
     */
    public function init(): void
    {
        $this->add(
            (new Password('currentPassword'))
                ->setLabel('Your current password')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Password('password'))
                ->setLabel('New password')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Password('passwordConfirm'))
                ->setLabel('New password confirmation')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Csrf('changePasswordCsrf'))
                ->setOptions([
                    'csrf_options' => ['timeout' => 3600, 'session' => new Container()],
                ])
                ->setAttribute('required', true)
        );
        $this->add(
            (new Submit('submit'))
                ->setAttribute('type', 'submit')
                ->setAttribute('value', 'Change Password')
                ->setAttribute('class', 'btn btn-sm btn-primary')
        );
    }

    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}
