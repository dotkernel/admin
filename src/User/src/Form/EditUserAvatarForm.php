<?php

declare(strict_types=1);

namespace Admin\User\Form;

use Admin\App\InputFilter\Input\ImageInput;
use Admin\User\InputFilter\EditUserAvatarInputFilter;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\File;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Session\Container;

use function implode;

/** @template-extends Form<FormInterface> */
class EditUserAvatarForm extends Form
{
    protected InputFilterInterface $inputFilter;

    public function __construct(?string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->setAttribute('id', 'user-avatar-form');
        $this->setAttribute('class', 'row g-3 needs-validation');
        $this->setAttribute('novalidate', 'novalidate');

        $this->inputFilter = new EditUserAvatarInputFilter();
        $this->inputFilter->init();
    }

    public function init(): void
    {
        $this
            ->add(
                (new File('name'))
                    ->setLabel('Image')
                    ->setAttribute('required', true)
                    ->setAttribute('id', 'user-avatar-selector')
                    ->setAttribute('class', 'd-none')
                    ->setAttribute('accept', implode(',', ImageInput::$mimeTypes))
            )->add(
                (new Csrf('userAvatarEditCsrf'))
                    ->setOptions([
                        'csrf_options' => ['timeout' => 3600, 'session' => new Container()],
                    ])
                    ->setAttribute('required', true)
            )->add(
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
