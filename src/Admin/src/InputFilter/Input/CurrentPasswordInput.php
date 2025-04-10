<?php

declare(strict_types=1);

namespace Admin\Admin\InputFilter\Input;

use Admin\App\InputFilter\Input\PasswordInput;

class CurrentPasswordInput extends PasswordInput
{
    public function __construct(?string $name = null, bool $isRequired = true)
    {
        parent::__construct($name);

        $this->setRequired($isRequired);
    }
}
