<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Mezzio\Authentication\UserInterface;

class AdminIdentity implements UserInterface
{
    protected string $uuid     = '';
    protected string $identity = '';
    protected string $status   = '';
    protected array $roles     = [];
    protected array $details   = [];

    /**
     * @param array $roles
     * @param array $details
     */
    public function __construct(string $uuid, string $identity, string $status, array $roles = [], array $details = [])
    {
        $this->uuid     = $uuid;
        $this->identity = $identity;
        $this->status   = $status;
        $this->roles    = $roles;
        $this->details  = $details;
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
     * @psalm-suppress LessSpecificImplementedReturnType
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
