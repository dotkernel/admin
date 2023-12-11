<?php

declare(strict_types=1);

namespace Frontend\Setting\InputFilter;

use Frontend\Setting\InputFilter\Input\SettingIdentifierInput;
use Laminas\InputFilter\InputFilter;

/**
 * @extends InputFilter<object>
 */
class SettingInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(new SettingIdentifierInput('identifier', true));
    }
}
