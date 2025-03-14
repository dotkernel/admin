<?php

declare(strict_types=1);

namespace Core\Admin\Entity;

use Core\Admin\Enum\AdminStatusEnum;
use Mezzio\Authentication\UserInterface;

class AdminIdentity implements UserInterface
{
    public function __construct(
        protected string $uuid,
        protected string $identity,
        protected AdminStatusEnum $status,
        protected array $roles = [],
        protected array $details = []
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getStatus(): AdminStatusEnum
    {
        return $this->status;
    }

    public function getRoles(): iterable
    {
        return $this->roles;
    }

    /**
     * @psalm-return array<string, mixed>
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param mixed|null $default
     */
    public function getDetail(string $name, $default = null): mixed
    {
        return $this->details[$name] ?? $default;
    }
}
