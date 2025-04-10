<?php

declare(strict_types=1);

namespace Admin\Setting\InputFilter\Input;

use Core\App\Message;
use Core\Setting\Enum\SettingIdentifierEnum;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;

class IdentifierInput extends Input
{
    public function __construct(?string $name = null, bool $isRequired = true)
    {
        parent::__construct($name);

        $this->setRequired($isRequired);

        $this->getFilterChain()
            ->attachByName(StringTrim::class)
            ->attachByName(StripTags::class);

        $this->getValidatorChain()
            ->attachByName(NotEmpty::class, [
                'message' => Message::VALIDATOR_REQUIRED_FIELD,
            ], true)
            ->attachByName(InArray::class, [
                'haystack' => SettingIdentifierEnum::values(),
                'message'  => Message::invalidValue('identifier'),
            ], true);
    }
}
