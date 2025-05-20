<?php

declare(strict_types=1);

namespace Admin\Setting\InputFilter;

use Admin\Setting\InputFilter\Input\IdentifierInput;
use Admin\Setting\InputFilter\Input\ValueInput;
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type CreateSettingDataType array{
 *     identifier: non-empty-string,
 *     value: non-empty-string,
 * }
 * @extends AbstractInputFilter<CreateSettingDataType>
 */
class CreateSettingInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        $this->add(new IdentifierInput('identifier', true));
        $this->add(new ValueInput('value', false));
    }
}
