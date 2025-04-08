<?php

declare(strict_types=1);

namespace Admin\Setting\InputFilter;

use Admin\Setting\InputFilter\Input\IdentifierInput;
use Admin\Setting\InputFilter\Input\ValueInput;
use Laminas\InputFilter\InputFilter;

/**
 * @extends InputFilter<object>
 */
class CreateSettingInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(new IdentifierInput('identifier', true));
        $this->add(new ValueInput('value', false));
    }
}
