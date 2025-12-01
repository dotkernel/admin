<?php

declare(strict_types=1);

namespace Admin\Admin\Form;

use Admin\Admin\InputFilter\LoginInputFilter;
use Admin\App\Form\AbstractForm;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\Session\Container;

/**
 * @phpstan-import-type LoginDataType from LoginInputFilter
 * @extends AbstractForm<LoginDataType>
 */
class LoginForm extends AbstractForm
{
    /**
     * @param array<non-empty-string, mixed> $options
     * @throws ExceptionInterface
     */
    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'login-form');
        $this->setAttribute('class', 'needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new LoginInputFilter();
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
                ->setAttribute('class', 'form-control')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Password('password'))
                ->setLabel('Password')
                ->setAttribute('class', 'form-control')
                ->setAttribute('required', true)
        );
        $this->add(
            (new Csrf('loginCsrf'))
                ->setOptions([
                    'csrf_options' => ['timeout' => 3600, 'session' => new Container()],
                ])
                ->setAttribute('required', true)
        );
        $this->add(
            (new Submit('submit'))
                ->setAttribute('type', 'submit')
                ->setAttribute('value', 'Log in')
                ->setAttribute('class', 'btn btn-primary')
        );
    }
}
