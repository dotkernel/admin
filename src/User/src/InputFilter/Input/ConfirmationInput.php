<?php

declare(strict_types=1);

namespace Admin\User\InputFilter\Input;

use Core\App\Message;
use Laminas\InputFilter\Input;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;

class ConfirmationInput extends Input
{
    public function __construct(?string $name = null, bool $isRequired = true)
    {
        parent::__construct($name);

        $this->setRequired($isRequired);

        $this->getValidatorChain()
            ->attachByName(NotEmpty::class, [
                'message' => Message::USER_CONFIRM_DELETION,
            ], true)
            ->attachByName(InArray::class, [
                'message'  => Message::USER_CONFIRM_DELETION,
                'haystack' => [
                    'yes',
                ],
            ], true);
    }
}
