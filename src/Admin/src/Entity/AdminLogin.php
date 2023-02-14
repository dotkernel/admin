<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Entity\AbstractEntity;

/**
 * Class AdminLogin
 * @ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminLoginRepository")
 * @ORM\Table(name="admin_login")
 * @ORM\HasLifecycleCallbacks()
 * @package Frontend\Admin\Entity
 */
class AdminLogin extends AbstractEntity
{
    public const IS_MOBILE_YES = 'yes';
    public const IS_MOBILE_NO = 'no';
    public const LOGIN_SUCCESS = 'success';
    public const LOGIN_FAIL = 'fail';

    /**
     * @ORM\Column(name="adminIp", type="string", length=50, nullable=true)
     * @var string $adminIp
     */
    protected string $adminIp;

    /**
     * @ORM\Column(name="country", type="string", length=50, nullable=true)
     * @var string $country
     */
    protected string $country;

    /**
     * @ORM\Column(name="continent", type="string", length=50, nullable=true)
     * @var string $continent
     */
    protected string $continent;

    /**
     * @ORM\Column(name="organization", type="string", length=50, nullable=true)
     * @var string $organization
     */
    protected string $organization;

    /**
     * @ORM\Column(name="deviceType", type="string", length=20, nullable=true)
     * @var string|null $deviceType
     */
    protected ?string $deviceType;

    /**
     * @ORM\Column(name="deviceBrand", type="string", length=20, nullable=true)
     * @var string|null $deviceBrand
     */
    protected ?string $deviceBrand;

    /**
     * @ORM\Column(name="deviceModel", type="string", length=40, nullable=true)
     * @var string|null $deviceModel
     */
    protected ?string $deviceModel;

    /**
     * @ORM\Column(name="isMobile", type="string", columnDefinition="ENUM('yes', 'no')")
     * @var string|null $isMobile
     */
    protected ?string $isMobile;

    /**
     * @ORM\Column(name="osName", type="string", length=20, nullable=true)
     * @var string|null $osName
     */
    protected ?string $osName;

    /**
     * @ORM\Column(name="osVersion", type="string", length=20, nullable=true)
     * @var string|null $osVersion
     */
    protected ?string $osVersion;

    /**
     * @ORM\Column(name="osPlatform", type="string", length=20, nullable=true)
     * @var string|null $osPlatform
     */
    protected ?string $osPlatform;

    /**
     * @ORM\Column(name="clientType", type="string", length=20, nullable=true)
     * @var string|null $clientType
     */
    protected ?string $clientType;

    /**
     * @ORM\Column(name="clientName", type="string", length=40, nullable=true)
     * @var string|null $clientName
     */
    protected ?string $clientName;

    /**
     * @ORM\Column(name="clientEngine", type="string", length=20, nullable=true)
     * @var string|null $clientEngine
     */
    protected ?string $clientEngine;

    /**
     * @ORM\Column(name="clientVersion", type="string", length=20, nullable=true)
     * @var string|null $clientVersion
     */
    protected ?string $clientVersion;

    /**
     * @ORM\Column(name="loginStatus", type="string", columnDefinition="ENUM('success', 'fail')")
     * @var string|null $loginStatus
     */
    protected ?string $loginStatus;

    /**
     * @ORM\Column(name="identity", type="string", length=100)
     * @var string $identity
     */
    protected string $identity;

    /**
     * AdminLogin constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getAdminIp(): string
    {
        return $this->adminIp;
    }

    /**
     * @param string $adminIp
     * @return self
     */
    public function setAdminIp(string $adminIp): self
    {
        $this->adminIp = $adminIp;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return self
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContinent(): ?string
    {
        return $this->continent;
    }

    /**
     * @param string $continent
     * @return self
     */
    public function setContinent(string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     * @return self
     */
    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    /**
     * @param string|null $deviceType
     * @return self
     */
    public function setDeviceType(?string $deviceType): self
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceBrand(): ?string
    {
        return $this->deviceBrand;
    }

    /**
     * @param string|null $deviceBrand
     * @return self
     */
    public function setDeviceBrand(?string $deviceBrand): self
    {
        $this->deviceBrand = $deviceBrand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceModel(): ?string
    {
        return $this->deviceModel;
    }

    /**
     * @param string|null $deviceModel
     * @return self
     */
    public function setDeviceModel(?string $deviceModel): self
    {
        $this->deviceModel = $deviceModel;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsMobile(): ?string
    {
        return $this->isMobile;
    }

    /**
     * @param string|null $isMobile
     * @return self
     */
    public function setIsMobile(?string $isMobile): self
    {
        $this->isMobile = $isMobile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOsName(): ?string
    {
        return $this->osName;
    }

    /**
     * @param string|null $osName
     * @return self
     */
    public function setOsName(?string $osName): self
    {
        $this->osName = $osName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOsVersion(): ?string
    {
        return $this->osVersion;
    }

    /**
     * @param string|null $osVersion
     * @return self
     */
    public function setOsVersion(?string $osVersion): self
    {
        $this->osVersion = $osVersion;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOsPlatform(): ?string
    {
        return $this->osPlatform;
    }

    /**
     * @param string|null $osPlatform
     * @return self
     */
    public function setOsPlatform(?string $osPlatform): self
    {
        $this->osPlatform = $osPlatform;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientType(): ?string
    {
        return $this->clientType;
    }

    /**
     * @param string|null $clientType
     * @return self
     */
    public function setClientType(?string $clientType): self
    {
        $this->clientType = $clientType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    /**
     * @param string|null $clientName
     * @return self
     */
    public function setClientName(?string $clientName): self
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientEngine(): ?string
    {
        return $this->clientEngine;
    }

    /**
     * @param string|null $clientEngine
     * @return self
     */
    public function setClientEngine(?string $clientEngine): self
    {
        $this->clientEngine = $clientEngine;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientVersion(): ?string
    {
        return $this->clientVersion;
    }

    /**
     * @param string|null $clientVersion
     * @return self
     */
    public function setClientVersion(?string $clientVersion): self
    {
        $this->clientVersion = $clientVersion;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLoginStatus(): ?string
    {
        return $this->loginStatus;
    }

    /**
     * @param string|null $loginStatus
     * @return $this
     */
    public function setLoginStatus(?string $loginStatus): self
    {
        $this->loginStatus = $loginStatus;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    /**
     * @param string $identity
     * @return self
     */
    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }
}
