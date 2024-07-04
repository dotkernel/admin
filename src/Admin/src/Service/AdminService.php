<?php

declare(strict_types=1);

namespace Frontend\Admin\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\GeoIP\Service\LocationServiceInterface;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\Admin\Entity\AdminRole;
use Frontend\Admin\Repository\AdminRepository;
use Frontend\Admin\Repository\AdminRoleRepository;
use Frontend\App\Service\IpService;

use function implode;
use function is_string;
use function password_hash;

use const PASSWORD_DEFAULT;

class AdminService implements AdminServiceInterface
{
    #[Inject(
        LocationServiceInterface::class,
        AdminRepository::class,
        AdminRoleRepository::class,
        "config.resultCacheLifetime"
    )]
    public function __construct(
        protected LocationServiceInterface $locationService,
        protected AdminRepository $adminRepository,
        protected AdminRoleRepository $adminRoleRepository,
        int $cacheLifetime,
    ) {
        $this->adminRepository->setCacheLifetime($cacheLifetime);
    }

    public function getAdminRepository(): AdminRepository|EntityRepository
    {
        return $this->adminRepository;
    }

    public function exists(string $identity = ''): bool
    {
        return $this->adminRepository->exists($identity);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        ?string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        $result = [
            'rows'  => [],
            'total' => $this->getAdminRepository()->countAdmins($search),
        ];
        $admins = $this->getAdminRepository()->getAdmins($offset, $limit, $search, $sort, $order);

        /** @var Admin $admin */
        foreach ($admins as $admin) {
            $roles = [];
            /** @var AdminRole $role */
            foreach ($admin->getRoles() as $role) {
                $roles[] = $role->getName();
            }

            $result['rows'][] = [
                'uuid'      => $admin->getUuid()->toString(),
                'identity'  => $admin->getIdentity(),
                'firstName' => $admin->getFirstname(),
                'lastName'  => $admin->getLastname(),
                'roles'     => implode(", ", $roles),
                'status'    => $admin->getStatus(),
                'created'   => $admin->getCreated()->format("Y-m-d"),
            ];
        }

        return $result;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getAdminLogins(
        int $offset = 0,
        int $limit = 30,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        $result = [
            'rows'  => [],
            'total' => $this->getAdminRepository()->countAdminLogins(),
        ];

        $logins = $this->getAdminRepository()->getAdminLogins($offset, $limit, $sort, $order);
        foreach ($logins as $login) {
            $result['rows'][] = [
                'uuid'          => $login->getUuid()->toString(),
                'identity'      => $login->getIdentity(),
                'adminIp'       => $login->getAdminIp(),
                'loginStatus'   => $login->getLoginStatus(),
                'country'       => $login->getCountry(),
                'continent'     => $login->getContinent(),
                'organization'  => $login->getOrganization(),
                'deviceType'    => $login->getDeviceType(),
                'deviceBrand'   => $login->getDeviceBrand(),
                'deviceModel'   => $login->getDeviceModel(),
                'isMobile'      => $login->getIsMobile(),
                'osName'        => $login->getOsName(),
                'osVersion'     => $login->getOsVersion(),
                'osPlatform'    => $login->getOsVersion(),
                'clientType'    => $login->getClientType(),
                'clientName'    => $login->getClientName(),
                'clientEngine'  => $login->getClientEngine(),
                'clientVersion' => $login->getClientVersion(),
                'created'       => $login->getCreatedFormatted('Y-m-d'),
            ];
        }

        return $result;
    }

    /**
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function createAdmin(array $data): Admin
    {
        if ($this->exists($data['identity'])) {
            throw new \Frontend\App\Exception\ORMException('An account with this identity already exists.');
        }

        $admin = (new Admin())
            ->setIdentity($data['identity'])
            ->setPassword(password_hash($data['password'], PASSWORD_DEFAULT))
            ->setFirstname($data['firstName'])
            ->setLastname($data['lastName'])
            ->setStatus($data['status']);
        foreach ($data['roles'] as $roleUuid) {
            $admin->addRole(
                $this->adminRoleRepository->getRole($roleUuid)
            );
        }

        return $this->getAdminRepository()->saveAdmin($admin);
    }

    /**
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function updateAdmin(Admin $admin, array $data): Admin
    {
        if (! empty($data['identity'])) {
            if (! $this->exists($data['identity'])) {
                $admin->setIdentity($data['identity']);
            } elseif ($admin->getIdentity() !== $data['identity']) {
                throw new \Frontend\App\Exception\ORMException('An account with this identity already exists');
            }
        }
        if (! empty($data['password'])) {
            $admin->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        }
        if (! empty($data['firstName']) && is_string($data['firstName'])) {
            $admin->setFirstname($data['firstName']);
        }
        if (! empty($data['lastName']) && is_string($data['lastName'])) {
            $admin->setLastname($data['lastName']);
        }
        if (! empty($data['status'])) {
            $admin->setStatus($data['status']);
        }
        if (! empty($data['roles'])) {
            $admin->setRoles(new ArrayCollection());
            foreach ($data['roles'] as $roleUuid) {
                $role = $this->adminRoleRepository->getRole($roleUuid);
                $admin->addRole($role);
            }
        }

        $this->getAdminRepository()->saveAdmin($admin);

        return $admin;
    }

    public function logAdminVisit(array $serverParams, string $name, string $status): AdminLogin
    {
        /**
         * For device information
         *
         * @see https://github.com/dotkernel/dot-user-agent-sniffer
         */

        $ipAddress = IpService::getUserIp($serverParams);

        $country = ! empty($this->locationService->getCountry($ipAddress)->getName()) ?
            $this->locationService->getCountry($ipAddress)->getName() : '';

        $continent = ! empty($this->locationService->getContinent($ipAddress)->getName()) ?
            $this->locationService->getContinent($ipAddress)->getName() : '';

        $organization = ! empty($this->locationService->getOrganization($ipAddress)->getName()) ?
            $this->locationService->getOrganization($ipAddress)->getName() : '';

        $adminLogin = (new AdminLogin())
            ->setAdminIp($ipAddress)
            ->setContinent($continent)
            ->setCountry($country)
            ->setOrganization($organization)
            ->setDeviceType(null)
            ->setDeviceBrand(null)
            ->setDeviceModel(null)
            ->setIsMobile(AdminLogin::IS_MOBILE_NO)
            ->setOsName(null)
            ->setOsVersion(null)
            ->setOsPlatform(null)
            ->setClientType(null)
            ->setClientName(null)
            ->setClientEngine(null)
            ->setClientVersion(null)
            ->setLoginStatus($status)
            ->setIdentity($name);

        return $this->adminRepository->saveAdminVisit($adminLogin);
    }

    public function getAdminFormProcessedRoles(): array
    {
        $allRoles = $this->adminRoleRepository->getRoles();

        $roles = [];
        foreach ($allRoles as $role) {
            $roles[$role->getUuid()->toString()] = $role->getName();
        }

        return $roles;
    }
}
