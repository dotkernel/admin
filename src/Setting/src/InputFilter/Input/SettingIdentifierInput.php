<?php

declare(strict_types=1);

namespace Frontend\Setting\InputFilter\Input;

use Frontend\App\Message;
use Frontend\Setting\Entity\Setting;
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
                'message' => sprintf(Message::VALIDATOR_REQUIRED_FIELD_BY_NAME, 'Identifier'),
            ], true)
            ->attachByName(InArray::class, [
                'haystack' => Setting::IDENTIFIERS,
                'message'  => sprintf(Message::INVALID_VALUE, 'identifier'),
            ], true);
    }
}
