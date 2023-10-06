<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminLoginRepository")
 * @ORM\Table(name="admin_login")
 * @ORM\HasLifecycleCallbacks()
 */
class AdminLogin extends AbstractEntity
{
    public const IS_MOBILE_YES = 'yes';
    public const IS_MOBILE_NO  = 'no';
    public const LOGIN_SUCCESS = 'success';
    public const LOGIN_FAIL    = 'fail';

    /** @ORM\Column(name="adminIp", type="string", length=50, nullable=true) */
    protected ?string $adminIp = null;

    /** @ORM\Column(name="country", type="string", length=50, nullable=true) */
    protected ?string $country = null;

    /** @ORM\Column(name="continent", type="string", length=50, nullable=true) */
    protected ?string $continent = null;

    /** @ORM\Column(name="organization", type="string", length=50, nullable=true) */
    protected ?string $organization = null;

    /** @ORM\Column(name="deviceType", type="string", length=20, nullable=true) */
    protected ?string $deviceType = null;

    /** @ORM\Column(name="deviceBrand", type="string", length=20, nullable=true) */
    protected ?string $deviceBrand = null;

    /** @ORM\Column(name="deviceModel", type="string", length=40, nullable=true) */
    protected ?string $deviceModel = null;

    /** @ORM\Column(name="isMobile", type="string", columnDefinition="ENUM('yes', 'no')") */
    protected ?string $isMobile = null;

    /** @ORM\Column(name="osName", type="string", length=20, nullable=true) */
    protected ?string $osName = null;

    /** @ORM\Column(name="osVersion", type="string", length=20, nullable=true) */
    protected ?string $osVersion = null;

    /** @ORM\Column(name="osPlatform", type="string", length=20, nullable=true) */
    protected ?string $osPlatform = null;

    /** @ORM\Column(name="clientType", type="string", length=20, nullable=true) */
    protected ?string $clientType = null;

    /** @ORM\Column(name="clientName", type="string", length=40, nullable=true) */
    protected ?string $clientName = null;

    /** @ORM\Column(name="clientEngine", type="string", length=20, nullable=true) */
    protected ?string $clientEngine = null;

    /** @ORM\Column(name="clientVersion", type="string", length=20, nullable=true) */
    protected ?string $clientVersion = null;

    /** @ORM\Column(name="loginStatus", type="string", columnDefinition="ENUM('success', 'fail')") */
    protected ?string $loginStatus = null;

    /** @ORM\Column(name="identity", type="string", length=100) */
    protected ?string $identity = null;

    public function getAdminIp(): ?string
    {
        return $this->adminIp;
    }

    public function setAdminIp(?string $adminIp): self
    {
        $this->adminIp = $adminIp;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(?string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    public function setDeviceType(?string $deviceType): self
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    public function getDeviceBrand(): ?string
    {
        return $this->deviceBrand;
    }

    public function setDeviceBrand(?string $deviceBrand): self
    {
        $this->deviceBrand = $deviceBrand;

        return $this;
    }

    public function getDeviceModel(): ?string
    {
        return $this->deviceModel;
    }

    public function setDeviceModel(?string $deviceModel): self
    {
        $this->deviceModel = $deviceModel;

        return $this;
    }

    public function getIsMobile(): ?string
    {
        return $this->isMobile;
    }

    public function setIsMobile(?string $isMobile): self
    {
        $this->isMobile = $isMobile;

        return $this;
    }

    public function getOsName(): ?string
    {
        return $this->osName;
    }

    public function setOsName(?string $osName): self
    {
        $this->osName = $osName;

        return $this;
    }

    public function getOsVersion(): ?string
    {
        return $this->osVersion;
    }

    public function setOsVersion(?string $osVersion): self
    {
        $this->osVersion = $osVersion;

        return $this;
    }

    public function getOsPlatform(): ?string
    {
        return $this->osPlatform;
    }

    public function setOsPlatform(?string $osPlatform): self
    {
        $this->osPlatform = $osPlatform;

        return $this;
    }

    public function getClientType(): ?string
    {
        return $this->clientType;
    }

    public function setClientType(?string $clientType): self
    {
        $this->clientType = $clientType;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(?string $clientName): self
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getClientEngine(): ?string
    {
        return $this->clientEngine;
    }

    public function setClientEngine(?string $clientEngine): self
    {
        $this->clientEngine = $clientEngine;

        return $this;
    }

    public function getClientVersion(): ?string
    {
        return $this->clientVersion;
    }

    public function setClientVersion(?string $clientVersion): self
    {
        $this->clientVersion = $clientVersion;

        return $this;
    }

    public function getLoginStatus(): ?string
    {
        return $this->loginStatus;
    }

    public function setLoginStatus(?string $loginStatus): self
    {
        $this->loginStatus = $loginStatus;

        return $this;
    }

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }
}
