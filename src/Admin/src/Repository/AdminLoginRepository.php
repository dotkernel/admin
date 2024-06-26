<?php

declare(strict_types=1);

namespace Frontend\Admin\Repository;

use Dot\DependencyInjection\Attribute\Entity;
use Frontend\Admin\Entity\AdminLogin;
use Frontend\App\Repository\AbstractRepository;

#[Entity(AdminLogin::class)]
class AdminLoginRepository extends AbstractRepository
{
}
