<?php

declare(strict_types=1);

namespace FrontendTest\Functional;

use Doctrine\ORM\Tools\SchemaTool;
use FrontendTest\Common\TestCase;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function realpath;

class FunctionalTest extends TestCase
{
    use HttpRequestTrait;
    use HttpResponseTrait;

    protected ?Application $app = null;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->initPipeline();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getApp(): Application
    {
        if (! $this->app instanceof Application) {
            $this->app = $this->getContainer()->get(Application::class);
        }

        return $this->app;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function initPipeline(): void
    {
        (require realpath(__DIR__ . '/../../config/pipeline.php'))(
            $this->getApp(),
            $this->getContainer()->get(MiddlewareFactory::class),
            $this->getContainer()
        );
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function runMigrations(): void
    {
        (new SchemaTool($this->getEntityManager()))->updateSchema(
            $this->getEntityManager()->getMetadataFactory()->getAllMetadata()
        );
    }
}
