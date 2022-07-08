<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Entity\AbstractEntity;

/**
 * Class AdminLogin
 * @ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminLoginsRepository")
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
     * @ORM\Column(name="adminIp", type="string", length=50, nullable=false, unique=true)
     * @var string $adminIp
     */
    protected string $adminIp;

    /**
     * @ORM\Column(name="country", type="string", length=50)
     * @var string $country
     */
    protected string $country;

    /**
     * @ORM\Column(name="continent", type="string", length=50)
     * @var string $continent
     */
    protected string $continent;

    /**
     * @ORM\Column(name="organization", type="string", length=50)
     * @var string $organization
     */
    protected string $organization;

    /**
     * @ORM\Column(name="deviceType", type="string", length=20)
     * @var string|null $deviceType
     */
    protected $deviceType;

    /**
     * @ORM\Column(name="deviceBrand", type="string", length=20)
     * @var string|null $deviceBrand
     */
    protected $deviceBrand;

    /**
     * @ORM\Column(name="deviceModel", type="string", length=40)
     * @var string|null $deviceModel
     */
    protected $deviceModel;

    /**
     * @ORM\Column(name="isMobile", type="string", columnDefinition="ENUM('yes', 'no')")
     * @var string|null $isMobile
     */
    protected $isMobile;

    /**
     * @ORM\Column(name="osName", type="string", length=20)
     * @var string|null $osName
     */
    protected $osName;

    /**
     * @ORM\Column(name="osVersion", type="string", length=20)
     * @var string|null $osVersion
     */
    protected $osVersion;

    /**
     * @ORM\Column(name="osPlatform", type="string", length=20)
     * @var string|null $osPlatform
     */
    protected $osPlatform;

    /**
     * @ORM\Column(name="clientType", type="string", length=20)
     * @var string|null $clientType
     */
    protected $clientType;

    /**
     * @ORM\Column(name="clientName", type="string", length=40)
     * @var string|null $clientName
     */
    protected $clientName;

    /**
     * @ORM\Column(name="clientEngine", type="string", length=20)
     * @var string|null $clientEngine
     */
    protected $clientEngine;

    /**
     * @ORM\Column(name="clientVersion", type="string", length=20)
     * @var string|null $clientVersion
     */
    protected $clientVersion;

    /**
     * @ORM\Column(name="loginStatus", type="string", columnDefinition="ENUM('success', 'fail')")
     * @var string|null $loginStatus
     */
    protected $loginStatus;

    /**
     * @ORM\Column(name="identity", type="string", length=100, nullable=false, unique=true)
     * @var string $identity
     */
    protected string $identity;

    /**
     * Admin constructor.
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
     * @return $this
     */
    public function setAdminIp(string $adminIp)
    {
        $this->adminIp = $adminIp;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getContinent(): ?string
    {
        return $this->continent;
    }

    /**
     * @param string $continent
     * @return $this
     */
    public function setContinent(string $continent)
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     * @return $this
     */
    public function setOrganization(string $organization)
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
     * @return $this
     */
    public function setDeviceType(?string $deviceType)
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
     * @return $this
     */
    public function setDeviceBrand(?string $deviceBrand)
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
     * @return $this
     */
    public function setDeviceModel(?string $deviceModel)
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
     * @return $this
     */
    public function setIsMobile(?string $isMobile)
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
     * @return $this
     */
    public function setOsName(?string $osName)
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
     * @return $this
     */
    public function setOsVersion(?string $osVersion)
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
     * @return $this
     */
    public function setOsPlatform(?string $osPlatform)
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
     * @return $this
     */
    public function setClientType(?string $clientType)
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
     * @return $this
     */
    public function setClientName(?string $clientName)
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
     * @return $this
     */
    public function setClientEngine(?string $clientEngine)
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
     * @return $this
     */
    public function setClientVersion(?string $clientVersion)
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
     */
    public function setLoginStatus(?string $loginStatus)
    {
        $this->loginStatus = $loginStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    /**
     * @param string $identity
     */
    public function setIdentity(string $identity)
    {
        $this->identity = $identity;

        return $this;
    }
}
