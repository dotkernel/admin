<?php

declare(strict_types=1);

namespace Admin\App\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterInterface;

/**
 * @phpstan-type SelectDataType array{
 *     label: non-empty-string,
 *     value: non-empty-string,
 *     selected: bool,
 * }
 * @template TFilteredValues
 * @extends Form<TFilteredValues>
 */
abstract class AbstractForm extends Form
{
    /** @var InputFilterInterface<TFilteredValues> $inputFilter */
    protected InputFilterInterface $inputFilter;

    /**
     * @return InputFilterInterface<TFilteredValues>
     */
    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}
