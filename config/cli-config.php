<?php

declare(strict_types=1);

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;

$container = require __DIR__ . '/container.php';

$config = new PhpFile('config/migrations.php');

$entityManager = $container->get(EntityManager::class);

// register enum type for doctrine
$entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
