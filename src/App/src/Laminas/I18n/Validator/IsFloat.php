<?php

declare(strict_types=1);

namespace Admin\App\Laminas\I18n\Validator;

use Laminas\Validator\AbstractValidator;

class IsFloat extends AbstractValidator
{
    /**
     * @inheritDoc
     */
    public function isValid($value): false
    {
        return false;
    }
}
