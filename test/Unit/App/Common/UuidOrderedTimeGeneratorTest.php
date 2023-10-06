<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Common;

use Frontend\App\Common\UuidOrderedTimeGenerator;
use FrontendTest\Unit\UnitTest;
use Ramsey\Uuid\UuidInterface;

class UuidOrderedTimeGeneratorTest extends UnitTest
{
    public function testWillGenerateUuid(): void
    {
        $firstUuid = UuidOrderedTimeGenerator::generateUuid();
        $this->assertInstanceOf(UuidInterface::class, $firstUuid);

        $secondUuid = UuidOrderedTimeGenerator::generateUuid();
        $this->assertInstanceOf(UuidInterface::class, $secondUuid);

        $this->assertNotSame($firstUuid, $secondUuid);
    }
}
