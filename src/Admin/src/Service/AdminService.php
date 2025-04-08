<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminRole;
use Core\Admin\Enum\AdminStatusEnum;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Repository\AdminRoleRepository;
use Core\App\Exception\BadRequestException;
use Core\App\Exception\ConflictException;
use Core\App\Exception\NotFoundException;
use Core\App\Helper\Paginator;
use Core\App\Message;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Dot\DependencyInjection\Attribute\Inject;
use Ramsey\Uuid\UuidInterface;

use function array_key_exists;
use function in_array;

class AdminService implements AdminServiceInterface
{
    #[Inject(
        AdminRepository::class,
        AdminRoleRepository::class,
    )]
    public function __construct(
        protected AdminRepository $adminRepository,
        protected AdminRoleRepository $adminRoleRepository,
    ) {
    }

    public function getAdminRepository(): AdminRepository
    {
        return $this->adminRepository;
    }

    /**
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function createAdmin(array $data): Admin
    {
        $status = $data['status'];
        if (! $status instanceof AdminStatusEnum) {
            $status = AdminStatusEnum::tryFrom($data['status']);
        }
        if (! $status instanceof AdminStatusEnum) {
            throw new BadRequestException(Message::invalidValue('status'));
        }

        $admin = (new Admin())
            ->setIdentity($data['identity'])
            ->usePassword($data['password'])
            ->setFirstname($data['firstName'])
            ->setLastname($data['lastName'])
            ->setStatus($status);

        $this->validateUniqueAdmin($admin->getIdentity());

        foreach ($data['roles'] as $roleUuid) {
            $adminRole = $this->adminRoleRepository->find($roleUuid);
            if (! $adminRole instanceof AdminRole) {
                throw new NotFoundException(Message::ROLE_NOT_FOUND);
            }
            $admin->addRole($adminRole);
        }

        if (! $admin->hasRoles()) {
            throw (new BadRequestException())->setMessages([Message::RESTRICTION_ROLES]);
        }

        $this->adminRepository->saveResource($admin);

        return $admin;
    }

    public function deleteAdmin(Admin $admin): void
    {
        $this->adminRepository->deleteResource($admin);
    }

    /**
     * @throws NotFoundException
     */
    public function find(string $uuid): Admin
    {
        $admin = $this->adminRepository->find($uuid);
        if (! $admin instanceof Admin) {
            throw new NotFoundException(Message::ADMIN_NOT_FOUND);
        }

        return $admin;
    }

    /**
     * @param array<string, mixed> $params
     */
    public function getAdmins(array $params): array
    {
        $filters = $params['filters'] ?? [];
        $params  = Paginator::getParams($params, 'admin.created');

        $sortableColumns = [
            'admin.identity',
            'admin.firstName',
            'admin.lastName',
            'admin.status',
            'admin.created',
            'admin.updated',
            'role.name',
        ];
        if (! in_array($params['sort'], $sortableColumns, true)) {
            $params['sort'] = 'admin.created';
        }

        $paginator = new DoctrinePaginator($this->adminRepository->getAdmins($params, $filters)->getQuery());

        return Paginator::wrapper($paginator, $params, $filters);
    }

    /**
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function updateAdmin(Admin $admin, array $data): Admin
    {
        if (array_key_exists('identity', $data)) {
            $admin->setIdentity($data['identity']);
        }
        if (array_key_exists('password', $data)) {
            $admin->usePassword($data['password']);
        }
        if (array_key_exists('firstName', $data)) {
            $admin->setFirstname($data['firstName']);
        }
        if (array_key_exists('lastName', $data)) {
            $admin->setLastname($data['lastName']);
        }
        if (array_key_exists('status', $data)) {
            $status = $data['status'];
            if (! $status instanceof AdminStatusEnum) {
                $status = AdminStatusEnum::tryFrom($status);
            }
            if (! $status instanceof AdminStatusEnum) {
                throw new BadRequestException(Message::invalidValue('status'));
            }
            $admin->setStatus($status);
        }

        $this->validateUniqueAdmin($admin->getIdentity(), $admin->getUuid());

        if (array_key_exists('roles', $data)) {
            $admin->resetRoles();
            foreach ($data['roles'] as $roleUuid) {
                $adminRole = $this->adminRoleRepository->find($roleUuid);
                if (! $adminRole instanceof AdminRole) {
                    throw new NotFoundException(Message::ROLE_NOT_FOUND);
                }
                $admin->addRole($adminRole);
            }
        }

        if (! $admin->hasRoles()) {
            throw (new BadRequestException())->setMessages([Message::RESTRICTION_ROLES]);
        }

        $this->adminRepository->saveResource($admin);

        return $admin;
    }

    /**
     * @throws ConflictException
     */
    private function validateUniqueAdmin(string $identity, ?UuidInterface $uuid = null): void
    {
        $admin = $this->adminRepository->findOneBy(['identity' => $identity]);
        if ($admin instanceof Admin) {
            if ($uuid === null) {
                throw new ConflictException(Message::DUPLICATE_IDENTITY);
            }
            if ($admin->getUuid()->toString() !== $uuid->toString()) {
                throw new ConflictException(Message::DUPLICATE_IDENTITY);
            }
        }
    }
}
