<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Admin\Admin\InputFilter\ChangePasswordInputFilter;
use Admin\Admin\InputFilter\CreateAdminInputFilter;
use Admin\Admin\InputFilter\EditAccountInputFilter;
use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminRole;
use Core\Admin\Enum\AdminStatusEnum;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Repository\AdminRoleRepository;
use Core\App\Helper\Paginator;
use Core\App\Message;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Dot\DependencyInjection\Attribute\Inject;
use Ramsey\Uuid\UuidInterface;

use function array_key_exists;
use function count;
use function in_array;

/**
 * @phpstan-import-type CreateAdminDataType from CreateAdminInputFilter
 * @phpstan-import-type EditAccountDataType from EditAccountInputFilter
 * @phpstan-import-type ChangePasswordDataType from ChangePasswordInputFilter
 */
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

    public function deleteAdmin(Admin $admin): void
    {
        $this->adminRepository->deleteResource($admin);
    }

    /**
     * @throws NotFoundException
     */
    public function findAdmin(string $uuid): Admin
    {
        $admin = $this->adminRepository->find($uuid);
        if (! $admin instanceof Admin) {
            throw new NotFoundException(Message::ADMIN_NOT_FOUND);
        }

        return $admin;
    }

    /**
     * @param array<non-empty-string, mixed> $params
     * @return array<non-empty-string, mixed>
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
     * @phpstan-param CreateAdminDataType|EditAccountDataType|ChangePasswordDataType $data
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function saveAdmin(array $data, ?Admin $admin = null): Admin
    {
        if (! $admin instanceof Admin) {
            $admin = new Admin();
        }

        if (array_key_exists('identity', $data) && $data['identity'] !== null && ! $admin->hasIdentity()) {
            $admin->setIdentity($data['identity']);
        }
        if (array_key_exists('password', $data) && $data['password'] !== null && $data['password'] !== '') {
            $admin->usePassword($data['password']);
        }
        if (array_key_exists('firstName', $data) && $data['firstName'] !== null) {
            $admin->setFirstName($data['firstName']);
        }
        if (array_key_exists('lastName', $data) && $data['lastName'] !== null) {
            $admin->setLastName($data['lastName']);
        }
        if (array_key_exists('status', $data) && $data['status'] !== null) {
            $status = $data['status'];
            if (! $status instanceof AdminStatusEnum) {
                $status = AdminStatusEnum::tryFrom($status);
            }
            if (! $status instanceof AdminStatusEnum) {
                throw new BadRequestException(Message::invalidValue('status'));
            }
            $admin->setStatus($status);
        }

        $this->validateUniqueAdmin((string) $admin->getIdentity(), $admin->getUuid());

        if (array_key_exists('roles', $data) && count($data['roles']) > 0) {
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
            throw new BadRequestException(Message::RESTRICTION_ROLES);
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
