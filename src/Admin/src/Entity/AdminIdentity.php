<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Mezzio\Authentication\UserInterface;

class AdminIdentity implements UserInterface
{
    public function __construct(
        protected string $uuid,
        protected string $identity,
        protected string $status,
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

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return iterable
     */
    public function getRoles(): iterable
    {
        return $this->roles;
    }

    /**
     * @return array
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
