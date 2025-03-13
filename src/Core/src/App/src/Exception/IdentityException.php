<?php

declare(strict_types=1);

namespace Core\App\Exception;

use Admin\App\Message;
use Fig\Http\Message\StatusCodeInterface;
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
