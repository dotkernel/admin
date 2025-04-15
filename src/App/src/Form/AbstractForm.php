<?php

declare(strict_types=1);

namespace Admin\App\Form;

use Laminas\Form\Form;
use Laminas\Form\FormInterface;
use Laminas\InputFilter\InputFilterInterface;

/**
 * @template-extends Form<FormInterface>
 */
abstract class AbstractForm extends Form
{
    protected InputFilterInterface $inputFilter;
}
