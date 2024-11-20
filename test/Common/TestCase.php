<?php

declare(strict_types=1);

namespace AdminTest\Common;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

use function realpath;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected ?ContainerInterface $container         = null;
    protected ?EntityManagerInterface $entityManager = null;

    protected function setUp(): void
    {
        TestMode::enable();
        $this->ensureTestMode();
    }

    private function ensureTestMode(): void
    {
        if (! TestMode::isEnabled()) {
            throw new RuntimeException(
                'You are running tests, but test mode is NOT enabled. Did you forget to create local.test.php?'
            );
        }

        if (! ($this->getEntityManager()->getConnection()->getParams()['memory'] ?? false)) {
            throw new RuntimeException(
                'You are running tests in a non in-memory database. Did you forget to create local.test.php?'
            );
        }
    }

    protected function tearDown(): void
    {
        TestMode::disable();
    }

    protected function getContainer(): ContainerInterface
    {
        if (! $this->container instanceof ContainerInterface) {
            $this->container = require realpath(__DIR__ . '/../../config/container.php');
        }

        return $this->container;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        if (! $this->entityManager instanceof EntityManagerInterface) {
            $this->entityManager = $this->getContainer()->get(EntityManager::class);
        }

        return $this->entityManager;
    }
}
