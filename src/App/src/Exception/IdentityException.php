<?php

declare(strict_types=1);

namespace Frontend\App\Exception;

use Fig\Http\Message\StatusCodeInterface;
use Frontend\App\Message;
use RuntimeException;

class IdentityException extends RuntimeException
{
    public static function duplicate(
        ?string $message = null,
        int $errorCode = StatusCodeInterface::STATUS_BAD_REQUEST
    ): self {
        $message = $message ?? Message::ADMIN_IDENTITY_EXISTS;
        return new self($message, $errorCode);
    }
}
