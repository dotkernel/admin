<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminLogin;
use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Repository\AdminLoginRepository;
use Admin\Admin\Repository\AdminRepository;
use Admin\Admin\Repository\AdminRoleRepository;
use Admin\App\Exception\IdentityException;
use Admin\App\Service\IpService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\GeoIP\Service\LocationServiceInterface;

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
        AdminLoginRepository::class,
    )]
    public function __construct(
        protected LocationServiceInterface $locationService,
        protected AdminRepository $adminRepository,
        protected AdminRoleRepository $adminRoleRepository,
        protected AdminLoginRepository $adminLoginRepository,
    ) {
    }

    public function getAdminRepository(): AdminRepository
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
        string $order = 'desc',
        array $filters = []
    ): array {
        $result = [
            'rows'  => [],
            'total' => $this->getAdminRepository()->countAdminLogins($filters),
        ];

        $logins = $this->getAdminRepository()->getAdminLogins($offset, $limit, $sort, $order, $filters);
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

    public function getAdminLoginIdentities(): array
    {
        return $this->adminLoginRepository->getAdminLoginIdentities();
    }

    public function createAdmin(array $data): Admin
    {
        if ($this->exists($data['identity'])) {
            throw IdentityException::duplicate();
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

    public function updateAdmin(Admin $admin, array $data): Admin
    {
        if (! empty($data['identity'])) {
            if (! $this->exists($data['identity'])) {
                $admin->setIdentity($data['identity']);
            } elseif ($admin->getIdentity() !== $data['identity']) {
                throw IdentityException::duplicate();
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

        $country      = $this->locationService->getCountry($ipAddress)->getName();
        $continent    = $this->locationService->getContinent($ipAddress)->getName();
        $organization = $this->locationService->getOrganization($ipAddress)->getName();

        $adminLogin = (new AdminLogin())
            ->setAdminIp(IpService::obfuscateIpAddress($ipAddress))
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
