<?php

declare(strict_types=1);

namespace Admin\User\InputFilter\Input;

use Core\App\Message;
use Laminas\InputFilter\Input;
use Laminas\Validator\NotEmpty;

class RolesInput extends Input
{
    public function __construct(?string $name = null, bool $isRequired = true)
    {
        parent::__construct($name);

        $this->setRequired($isRequired);

        $this->getValidatorChain()->attachByName(NotEmpty::class, [
            'message' => Message::RESTRICTION_ROLES,
        ], true);
    }
}
