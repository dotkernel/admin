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
use stdClass;

use function get_browser;
use function in_array;
use function ini_get;

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
     * @param array<non-empty-string, mixed> $params
     * @return array<non-empty-string, mixed>
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
            'login.isMobile',
            'login.osName',
            'login.osVersion',
            'login.clientType',
            'login.clientName',
            'login.isCrawler',
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
     * @param array{HTTP_X_FORWARDED_FOR?: string, HTTP_CLIENT_IP?: string, REMOTE_ADDR: string} $serverParams
     * @throws Exception
     */
    public function logFailedLogin(array $serverParams, string $name): AdminLogin
    {
        return $this->logAdminVisit($serverParams, $name, SuccessFailureEnum::Fail);
    }

    /**
     * @param array{HTTP_X_FORWARDED_FOR?: string, HTTP_CLIENT_IP?: string, REMOTE_ADDR: string} $serverParams
     * @throws Exception
     */
    public function logSuccessfulLogin(array $serverParams, string $name): AdminLogin
    {
        return $this->logAdminVisit($serverParams, $name, SuccessFailureEnum::Success);
    }

    /**
     * @param array{HTTP_X_FORWARDED_FOR?: string, HTTP_CLIENT_IP?: string, REMOTE_ADDR: string} $serverParams
     * @throws Exception
     */
    private function logAdminVisit(array $serverParams, string $name, SuccessFailureEnum $status): AdminLogin
    {
        $ipAddress = IpService::getUserIp($serverParams);

        $country      = $this->locationService->getCountry($ipAddress)->getName();
        $continent    = $this->locationService->getContinent($ipAddress)->getName();
        $organization = $this->locationService->getOrganization($ipAddress)->getName();

        /**
         * For browscap information
         *
         * @see https://www.php.net/manual/en/function.get-browser.php
         */
        $browser = new stdClass();
        if (ini_get('browscap')) {
            $browser = get_browser($_SERVER['HTTP_USER_AGENT']);
        }

        $adminLogin = (new AdminLogin())
            ->setAdminIp($this->locationService->obfuscateIpAddress($ipAddress))
            ->setContinent($continent)
            ->setCountry($country)
            ->setOrganization($organization)
            ->setDeviceType(! empty($browser->device_type) ? $browser->device_type : null)
            ->setIsMobile(
                ! empty($browser->ismobiledevice) ? YesNoEnum::Yes : YesNoEnum::No
            )
            ->setOsName(! empty($browser->platform) ? $browser->platform : null)
            ->setOsVersion(! empty($browser->platform_version) ? $browser->platform_version : null)
            ->setClientType(! empty($browser->browser_type) ? $browser->browser_type : null)
            ->setClientName(! empty($browser->browser) ? $browser->browser : null)
            ->setLoginStatus($status)
            ->setIsCrawler(! empty($browser->crawler) ? YesNoEnum::Yes : YesNoEnum::No)
            ->setIdentity($name);

        $this->adminLoginRepository->saveResource($adminLogin);

        return $adminLogin;
    }
}
