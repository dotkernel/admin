<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Mezzio\Authentication\UserInterface;

/**
 * Class AdminIdentity
 * @package Frontend\Admin\Entity
 */
class AdminIdentity implements UserInterface
{
    protected string $uuid = '';
    protected string $identity = '';
    protected string $status = '';
    protected array $roles = [];
    protected array $details = [];

    /**
     * AdminIdentity constructor.
     * @param string $uuid
     * @param string $identity
     * @param string $status
     * @param array $roles
     * @param array $details
     */
    public function __construct(string $uuid, string $identity, string $status, array $roles = [], array $details = [])
    {
        $this->uuid = $uuid;
        $this->identity = $identity;
        $this->status = $status;
        $this->roles = $roles;
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * @return string
     */
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
     * @param string $name
     * @param mixed|null $default
     * @return null|array<string, mixed>
     */
    public function getDetail(string $name, $default = null)
    {
        return $this->details[$name] ?? $default;
    }
}
