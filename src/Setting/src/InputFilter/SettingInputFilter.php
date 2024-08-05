<?php

declare(strict_types=1);

namespace Admin\Setting\InputFilter;

use Admin\Setting\InputFilter\Input\SettingIdentifierInput;
use Admin\Setting\InputFilter\Input\SettingValueInput;
use Laminas\InputFilter\InputFilter;

/**
 * @extends InputFilter<object>
 */
class SettingInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(new SettingIdentifierInput('identifier', true));
        $this->add(new SettingValueInput('value', false));
    }
}
