<?php

declare(strict_types=1);

namespace Frontend\Admin\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Doctrine\ORM\EntityManager;
use Dot\GeoIP\Service\LocationServiceInterface;
use Dot\UserAgentSniffer\Service\DeviceServiceInterface;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\Admin\Entity\AdminRole;
use Frontend\Admin\Repository\AdminRepository;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Repository\AdminRoleRepository;

/**
 * Class AdminService
 * @package Frontend\Admin\Service
 *
 * @Service
 */
class AdminService implements AdminServiceInterface
{
    /** @var EntityManager $em */
    protected EntityManager $em;

    /** @var AdminRepository $adminRepository */
    protected AdminRepository $adminRepository;

    /** @var AdminRoleRepository $adminRoleRepository */
    protected AdminRoleRepository $adminRoleRepository;

    /** @var LocationServiceInterface $locationService */
    protected LocationServiceInterface $locationService;

    /** @var DeviceServiceInterface $deviceService */
    protected DeviceServiceInterface $deviceService;

    /**
     * AdminService constructor.
     * @param EntityManager $em
     * @param LocationServiceInterface $locationService
     * @param DeviceServiceInterface $deviceService
     * @param int $cacheLifetime
     *
     * @Inject({EntityManager::class, LocationServiceInterface::class, DeviceServiceInterface::class,
     *      "config.resultCacheLifetime"})
     */
    public function __construct(
        EntityManager $em,
        LocationServiceInterface $locationService,
        DeviceServiceInterface $deviceService,
        int $cacheLifetime
    ) {

        $this->em = $em;
        $this->adminRepository = $em->getRepository(Admin::class);
        $this->adminRoleRepository = $em->getRepository(AdminRole::class);
        $this->adminRepository->setCacheLifetime($cacheLifetime);
        $this->locationService = $locationService;
        $this->deviceService = $deviceService;
    }

    /**
     * @param array $params
     * @return Admin|null
     */
    public function findAdminBy(array $params): ?Admin
    {
        return $this->adminRepository->findAdminBy($params);
    }

    /**
     * @return AdminRepository
     */
    public function getAdminRepository(): AdminRepository
    {
        return $this->adminRepository;
    }

    /**
     * @param string $identity
     * @return bool
     */
    public function exists(string $identity = ''): bool
    {
        return !is_null(
            $this->adminRepository->exists($identity)
        );
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getAdmins(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        $result = [
            'rows' => [],
            'total' => $this->getAdminRepository()->countAdmins($search)
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
                'uuid' => $admin->getUuid()->toString(),
                'identity' => $admin->getIdentity(),
                'firstName' => $admin->getFirstname(),
                'lastName' => $admin->getLastname(),
                'roles' => implode(", ", $roles),
                'status' => $admin->getStatus(),
                'created' => $admin->getCreated()->format("Y-m-d")
            ];
        }

        return $result;
    }

    /**
     * @param array $data
     * @return Admin
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createAdmin(array $data): Admin
    {
        if ($this->exists($data['identity'])) {
            throw new ORMException('An account with this identity already exists.');
        }

        $admin = new Admin();
        $admin->setIdentity($data['identity']);
        $admin->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        $admin->setFirstname($data['firstName']);
        $admin->setLastname($data['lastName']);
        $admin->setStatus($data['status']);
        foreach ($data['roles'] as $roleUuid) {
            $role = $this->adminRoleRepository->getRole($roleUuid);
            $admin->addRole($role);
        }

        $this->getAdminRepository()->saveAdmin($admin);

        return $admin;
    }

    /**
     * @param Admin|object $admin
     * @param array $data
     * @return Admin
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateAdmin(Admin $admin, array $data)
    {
        if (!empty($data['identity'])) {
            if (!$this->exists($data['identity'])) {
                $admin->setIdentity($data['identity']);
            } elseif ($admin->getIdentity() !== $data['identity']) {
                throw new ORMException('An account with this identity already exists');
            }
        }
        if (!empty($data['password'])) {
            $admin->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        }
        if (is_string($data['firstName'])) {
            $admin->setFirstname($data['firstName']);
        }
        if (is_string($data['lastName'])) {
            $admin->setLastname($data['lastName']);
        }
        if (!empty($data['status'])) {
            $admin->setStatus($data['status']);
        }
        if (!empty($data['roles'])) {
            $admin->setRoles(new ArrayCollection());
            foreach ($data['roles'] as $roleUuid) {
                $role = $this->adminRoleRepository->getRole($roleUuid);
                $admin->addRole($role);
            }
        }

        $this->getAdminRepository()->saveAdmin($admin);

        return $admin;
    }

    /**
     * @param $request
     * @param $name
     * @return AdminLogin
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function logAdminVisit($request, $name): AdminLogin
    {
        $deviceData = $this->deviceService->getDetails($request['HTTP_USER_AGENT']);
        $deviceOs = !empty($deviceData->getOs()) ? $deviceData->getOs() : null;
        $deviceClient = !empty($deviceData->getClient()) ? $deviceData->getClient() : null;

        $ipAddress = null;
        if (!empty($request['REMOTE_ADDR'])) {
            $ipAddress = $request['REMOTE_ADDR'];
        } elseif (!empty($request['HTTP_CLIENT_IP'])) {
            $ipAddress = $request['HTTP_CLIENT_IP'];
        } else {
            $ipAddress = $request['HTTP_X_FORWARDED_FOR'];
        }

        $adminLogins = new AdminLogin();

//        $country = !empty($this->locationService->getCountry($ipAddress)) ?
//            $this->locationService->getCountry($ipAddress)->getName() : '';
//        $continent = !empty($this->locationService->getContinent($ipAddress)) ?
//            $this->locationService->getContinent($ipAddress)->getName() : '';
//        $organization = !empty($this->locationService->getOrganization($ipAddress)) ?
//            $this->locationService->getOrganization($ipAddress)->getName() : '';
        $deviceType = !empty($deviceData->getType()) ? $deviceData->getType() : null;
        $deviceBrand = !empty($deviceData->getBrand()) ? $deviceData->getBrand() : null;
        $deviceModel = !empty($deviceData->getModel()) ? $deviceData->getModel() : null;
        $isMobile = $deviceData->getIsMobile() ? AdminLogin::IS_MOBILE_YES : AdminLogin::IS_MOBILE_NO;
        $osName = !empty($deviceOs->getName()) ? $deviceOs->getName() : null;
        $osVersion = !empty($deviceOs->getVersion()) ? $deviceOs->getVersion() : null;
        $osPlatform = !empty($deviceOs->getPlatform()) ? $deviceOs->getPlatform() : null;
        $clientType = !empty($deviceClient->getType()) ? $deviceClient->getType() : null;
        $clientName = !empty($deviceClient->getName()) ? $deviceClient->getName() : null;
        $clientEngine = !empty($deviceClient->getEngine()) ? $deviceClient->getEngine() : null;
        $clientVersion = !empty($deviceClient->getVersion()) ? $deviceClient->getVersion() : null;

        $adminLogins->setAdminIp($ipAddress)
            ->setContinent('')
            ->setCountry('')
            ->setOrganization('')
            ->setDeviceType($deviceType)
            ->setDeviceBrand($deviceBrand)
            ->setDeviceModel($deviceModel)
            ->setIsMobile($isMobile)
            ->setOsName($osName)
            ->setOsVersion($osVersion)
            ->setOsPlatform($osPlatform)
            ->setClientType($clientType)
            ->setClientName($clientName)
            ->setClientEngine($clientEngine)
            ->setClientVersion($clientVersion)
            ->setIdentity($name);

        $this->adminRepository->saveAdminVisit($adminLogins);

        return $adminLogins;
    }

    /**
     * @return array
     */
    public function getAdminFormProcessedRoles(): array
    {
        $roles = [];
        $result = $this->adminRoleRepository->getRoles();

        if (!empty($result)) {
            /** @var AdminRole $role */
            foreach ($result as $role) {
                $roles[$role->getUuid()->toString()] = $role->getName();
            }
        }

        return $roles;
    }
}
