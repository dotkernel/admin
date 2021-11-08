<?php

declare(strict_types=1);

namespace Frontend\User\Entity;

use Mezzio\Authentication\UserInterface;

/**
 * Class AdminIdentity
 * @package Frontend\User\Entity
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
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param string $name
     * @param null $default
     * @return string|null
     */
    public function getDetail(string $name, $default = null): ?string
    {
        return $this->details[$name] ?? $default;
    }
}
