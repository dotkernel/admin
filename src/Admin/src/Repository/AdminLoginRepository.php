<?php

declare(strict_types=1);

namespace Admin\Admin\Repository;

use Admin\Admin\Entity\AdminLogin;
use Admin\App\Repository\AbstractRepository;
use Dot\DependencyInjection\Attribute\Entity;

#[Entity(AdminLogin::class)]
class AdminLoginRepository extends AbstractRepository
{
}
