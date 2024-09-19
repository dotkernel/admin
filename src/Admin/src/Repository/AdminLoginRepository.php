<?php

declare(strict_types=1);

namespace Admin\Admin\Repository;

use Admin\Admin\Entity\AdminLogin;
use Admin\App\Repository\AbstractRepository;
use Dot\DependencyInjection\Attribute\Entity;

use function array_column;

#[Entity(AdminLogin::class)]
class AdminLoginRepository extends AbstractRepository
{
    public function getAdminLoginIdentities(): array
    {
        $results = $this->getQueryBuilder()
            ->select('DISTINCT adminLogin.identity')
            ->from(AdminLogin::class, 'adminLogin')
            ->orderBy('adminLogin.identity', 'ASC')
            ->getQuery()->getResult();

        return array_column($results, 'identity');
    }
}
