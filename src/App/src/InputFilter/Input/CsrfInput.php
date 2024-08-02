<?php

declare(strict_types=1);

namespace Frontend\App\InputFilter\Input;

use Frontend\App\Message;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\Session\Container;
use Laminas\Session\Validator\Csrf;
use Laminas\Validator\NotEmpty;

use function sprintf;

class CsrfInput extends Input
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
                'message' => sprintf(Message::VALIDATOR_REQUIRED_FIELD_BY_NAME, '<b>CSRF</b>'),
            ], true)
            ->attachByName(Csrf::class, [
                'name'    => $name,
                'message' => '<b>CSRF</b> is invalid',
                'session' => new Container(),
            ], true);
    }
}
