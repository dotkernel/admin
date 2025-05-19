<?php

declare(strict_types=1);

namespace Admin\App\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * @template TFilteredValues
 * @extends Form<TFilteredValues>
 */
abstract class AbstractForm extends Form
{
    /** @var InputFilterInterface<TFilteredValues> $inputFilter */
    protected InputFilterInterface $inputFilter;

    /**
     * @return InputFilterInterface&InputFilter<TFilteredValues>
     */
    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}
