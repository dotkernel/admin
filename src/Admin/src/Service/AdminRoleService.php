<?php

declare(strict_types=1);

namespace Admin\Admin\Service;

use Admin\Admin\Repository\AdminRoleRepository;
use Dot\DependencyInjection\Attribute\Inject;

class AdminRoleService implements AdminRoleServiceInterface
{
    #[Inject(
        AdminRoleRepository::class,
    )]
    public function __construct(
        protected AdminRoleRepository $adminRoleRepository,
    ) {
    }

    public function getRoles(): array
    {
        return $this->adminRoleRepository->getRoles();
    }
}
