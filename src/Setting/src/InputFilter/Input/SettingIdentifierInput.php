<?php

declare(strict_types=1);

namespace Admin\Setting\InputFilter\Input;

use Admin\App\Message;
use Admin\Setting\Enum\SettingEnum;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;

use function sprintf;

class SettingIdentifierInput extends Input
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
                'message' => sprintf(Message::VALIDATOR_REQUIRED_FIELD_BY_NAME, '<b>Identifier</b>'),
            ], true)
            ->attachByName(InArray::class, [
                'haystack' => SettingEnum::values(),
                'message'  => sprintf(Message::INVALID_VALUE, 'identifier'),
            ], true);
    }
}
