<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Core\Admin\Entity\AdminLogin;
use Core\Admin\Repository\AdminLoginRepository;
use Core\App\Enum\SuccessFailureEnum;
use Core\App\Enum\YesNoEnum;
use Core\App\Helper\Paginator;
use Core\App\Service\IpService;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\GeoIP\Service\LocationService;
use Exception;

use function in_array;

class AdminLoginService implements AdminLoginServiceInterface
{
    #[Inject(
        AdminLoginRepository::class,
        LocationService::class,
    )]
    public function __construct(
        protected AdminLoginRepository $adminLoginRepository,
        protected LocationService $locationService,
    ) {
    }

    public function getAdminLoginRepository(): AdminLoginRepository
    {
        return $this->adminLoginRepository;
    }

    /**
     * @param array<string, mixed> $params
     */
    public function getAdminLogins(array $params): array
    {
        $filters = $params['filters'] ?? [];
        $params  = Paginator::getParams($params, 'login.created');

        $sortableColumns = [
            'login.adminIp',
            'login.country',
            'login.continent',
            'login.organization',
            'login.deviceType',
            'login.deviceBrand',
            'login.deviceModel',
            'login.isMobile',
            'login.osName',
            'login.osVersion',
            'login.osPlatform',
            'login.clientType',
            'login.clientName',
            'login.clientEngine',
            'login.clientVersion',
            'login.loginStatus',
            'login.identity',
            'login.created',
            'login.updated',
        ];
        if (! in_array($params['sort'], $sortableColumns, true)) {
            $params['sort'] = 'login.created';
        }

        $paginator = new DoctrinePaginator(
            $this->getAdminLoginRepository()->getAdminLogins($params, $filters)->getQuery()
        );

        return Paginator::wrapper($paginator, $params, $filters);
    }

    /**
     * @throws Exception
     */
    public function logFailedLogin(array $serverParams, string $name): AdminLogin
    {
        return $this->logAdminVisit($serverParams, $name, SuccessFailureEnum::Fail);
    }

    /**
     * @throws Exception
     */
    public function logSuccessfulLogin(array $serverParams, string $name): AdminLogin
    {
        return $this->logAdminVisit($serverParams, $name, SuccessFailureEnum::Success);
    }

    /**
     * @throws Exception
     */
    private function logAdminVisit(array $serverParams, string $name, SuccessFailureEnum $status): AdminLogin
    {
        /**
         * For device information
         *
         * @see https://github.com/dotkernel/dot-user-agent-sniffer
         */

        $ipAddress = IpService::getUserIp($serverParams);

        $country      = $this->locationService->getCountry($ipAddress)->getName();
        $continent    = $this->locationService->getContinent($ipAddress)->getName();
        $organization = $this->locationService->getOrganization($ipAddress)->getName();

        $adminLogin = (new AdminLogin())
            ->setAdminIp($this->locationService->obfuscateIpAddress($ipAddress))
            ->setContinent($continent)
            ->setCountry($country)
            ->setOrganization($organization)
            ->setDeviceType(null)
            ->setDeviceBrand(null)
            ->setDeviceModel(null)
            ->setIsMobile(YesNoEnum::No)
            ->setOsName(null)
            ->setOsVersion(null)
            ->setOsPlatform(null)
            ->setClientType(null)
            ->setClientName(null)
            ->setClientEngine(null)
            ->setClientVersion(null)
            ->setLoginStatus($status)
            ->setIdentity($name);

        $this->adminLoginRepository->saveResource($adminLogin);

        return $adminLogin;
    }
}
