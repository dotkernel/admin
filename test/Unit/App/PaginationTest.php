<?php

declare(strict_types=1);

namespace AdminTest\Unit\App;

use Admin\App\Pagination;
use DivisionByZeroError;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function testWillNotInitializeWithoutLimit(): void
    {
        $this->expectException(DivisionByZeroError::class);
        new Pagination(10, 0, 0);
    }

    public function testWillInitializeWithZeroTotal(): void
    {
        $this->expectNotToPerformAssertions();
        new Pagination(0, 0, 10);
    }

    public function testWillInitializeWithLimitOnly(): void
    {
        $this->assertInstanceOf(Pagination::class, new Pagination(0, 0, 10));
    }

    public function testWillNotAlterTotal(): void
    {
        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(10, $pagination->getTotal());
    }

    public function testWillDetectFirstPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertTrue($pagination->isFirstPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertFalse($pagination->isFirstPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertTrue($pagination->isFirstPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertFalse($pagination->isFirstPage());
    }

    public function testWillGetFirstPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(1, $pagination->getFirstPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(1, $pagination->getFirstPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(1, $pagination->getFirstPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(1, $pagination->getFirstPage());

        $pagination = new Pagination(20, 0, 10);
        $this->assertEquals(1, $pagination->getFirstPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertEquals(1, $pagination->getFirstPage());

        $pagination = new Pagination(20, 20, 10);
        $this->assertEquals(1, $pagination->getFirstPage());
    }

    public function testWillDetectPreviousPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertFalse($pagination->hasPreviousPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertTrue($pagination->hasPreviousPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertFalse($pagination->hasPreviousPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertTrue($pagination->hasPreviousPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertTrue($pagination->hasPreviousPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertTrue($pagination->hasPreviousPage());

        $pagination = new Pagination(20, 20, 10);
        $this->assertTrue($pagination->hasPreviousPage());
    }

    public function testWillGetPreviousPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(1, $pagination->getPreviousPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(1, $pagination->getPreviousPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(1, $pagination->getPreviousPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(1, $pagination->getPreviousPage());

        $pagination = new Pagination(20, 0, 10);
        $this->assertEquals(1, $pagination->getPreviousPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertEquals(1, $pagination->getPreviousPage());

        $pagination = new Pagination(20, 20, 10);
        $this->assertEquals(2, $pagination->getPreviousPage());
    }

    public function testWillGetCurrentPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(1, $pagination->getCurrentPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(2, $pagination->getCurrentPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(1, $pagination->getCurrentPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(2, $pagination->getCurrentPage());

        $pagination = new Pagination(20, 0, 10);
        $this->assertEquals(1, $pagination->getCurrentPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertEquals(2, $pagination->getCurrentPage());

        $pagination = new Pagination(20, 20, 10);
        $this->assertEquals(3, $pagination->getCurrentPage());
    }

    public function testWillDetectNextPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertFalse($pagination->hasNextPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertFalse($pagination->hasNextPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertFalse($pagination->hasNextPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertFalse($pagination->hasNextPage());

        $pagination = new Pagination(20, 0, 10);
        $this->assertTrue($pagination->hasNextPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertFalse($pagination->hasNextPage());

        $pagination = new Pagination(20, 20, 10);
        $this->assertFalse($pagination->hasNextPage());
    }

    public function testWillGetNextPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(1, $pagination->getNextPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(1, $pagination->getNextPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(1, $pagination->getNextPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(1, $pagination->getNextPage());

        $pagination = new Pagination(20, 0, 10);
        $this->assertEquals(2, $pagination->getNextPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertEquals(2, $pagination->getNextPage());

        $pagination = new Pagination(20, 20, 10);
        $this->assertEquals(2, $pagination->getNextPage());
    }

    public function testWillGetLastPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(1, $pagination->getLastPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(1, $pagination->getLastPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(1, $pagination->getLastPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(1, $pagination->getLastPage());

        $pagination = new Pagination(20, 0, 10);
        $this->assertEquals(2, $pagination->getLastPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertEquals(2, $pagination->getLastPage());

        $pagination = new Pagination(20, 20, 10);
        $this->assertEquals(2, $pagination->getLastPage());
    }

    public function testWillDetectLastPage(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertTrue($pagination->isLastPage());

        $pagination = new Pagination(0, 10, 10);
        $this->assertFalse($pagination->isLastPage());

        $pagination = new Pagination(10, 0, 10);
        $this->assertTrue($pagination->isLastPage());

        $pagination = new Pagination(10, 10, 10);
        $this->assertFalse($pagination->isLastPage());

        $pagination = new Pagination(20, 0, 10);
        $this->assertFalse($pagination->isLastPage());

        $pagination = new Pagination(20, 10, 10);
        $this->assertTrue($pagination->isLastPage());

        $pagination = new Pagination(20, 20, 10);
        $this->assertFalse($pagination->isLastPage());
    }

    public function testWillDetectOutOfBounds(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertFalse($pagination->isOutOfBounds());

        $pagination = new Pagination(0, 10, 10);
        $this->assertTrue($pagination->isOutOfBounds());

        $pagination = new Pagination(10, 0, 10);
        $this->assertFalse($pagination->isOutOfBounds());

        $pagination = new Pagination(10, 10, 10);
        $this->assertTrue($pagination->isOutOfBounds());
    }

    public function testWillGetFirstOffset(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(0, $pagination->getFirstOffset());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(0, $pagination->getFirstOffset());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(0, $pagination->getFirstOffset());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(0, $pagination->getFirstOffset());
    }

    public function testWillGetPreviousOffset(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(0, $pagination->getPreviousOffset());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(0, $pagination->getPreviousOffset());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(0, $pagination->getPreviousOffset());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(0, $pagination->getPreviousOffset());

        $pagination = new Pagination(20, 0, 10);
        $this->assertEquals(0, $pagination->getPreviousOffset());

        $pagination = new Pagination(20, 10, 10);
        $this->assertEquals(0, $pagination->getPreviousOffset());

        $pagination = new Pagination(20, 20, 10);
        $this->assertEquals(10, $pagination->getPreviousOffset());
    }

    public function testWillGetNextOffset(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(0, $pagination->getNextOffset());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(0, $pagination->getNextOffset());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(0, $pagination->getNextOffset());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(0, $pagination->getNextOffset());

        $pagination = new Pagination(20, 0, 10);
        $this->assertEquals(10, $pagination->getNextOffset());

        $pagination = new Pagination(20, 10, 10);
        $this->assertEquals(10, $pagination->getNextOffset());

        $pagination = new Pagination(20, 20, 10);
        $this->assertEquals(10, $pagination->getNextOffset());
    }

    public function testWillGetLastOffset(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $this->assertEquals(0, $pagination->getLastOffset());

        $pagination = new Pagination(0, 10, 10);
        $this->assertEquals(0, $pagination->getLastOffset());

        $pagination = new Pagination(10, 0, 10);
        $this->assertEquals(0, $pagination->getLastOffset());

        $pagination = new Pagination(10, 10, 10);
        $this->assertEquals(0, $pagination->getLastOffset());

        $pagination = new Pagination(20, 0, 10);
        $this->assertEquals(10, $pagination->getLastOffset());

        $pagination = new Pagination(20, 10, 10);
        $this->assertEquals(10, $pagination->getLastOffset());

        $pagination = new Pagination(20, 20, 10);
        $this->assertEquals(10, $pagination->getLastOffset());
    }

    public function testWillGetPages(): void
    {
        $pagination = new Pagination(0, 0, 10);
        $pages      = $pagination->getPages();
        $this->assertCount(1, $pages);
        $this->assertContains(1, $pages);

        $pagination = new Pagination(0, 10, 10);
        $pages      = $pagination->getPages();
        $this->assertCount(1, $pages);
        $this->assertContains(1, $pages);

        $pagination = new Pagination(10, 0, 10);
        $pages      = $pagination->getPages();
        $this->assertCount(1, $pages);
        $this->assertContains(1, $pages);

        $pagination = new Pagination(10, 10, 10);
        $pages      = $pagination->getPages();
        $this->assertCount(1, $pages);
        $this->assertContains(1, $pages);

        $pagination = new Pagination(20, 0, 10);
        $pages      = $pagination->getPages();
        $this->assertCount(2, $pages);
        $this->assertContains(1, $pages);
        $this->assertContains(2, $pages);

        $pagination = new Pagination(20, 10, 10);
        $pages      = $pagination->getPages();
        $this->assertCount(2, $pages);
        $this->assertContains(1, $pages);
        $this->assertContains(2, $pages);

        $pagination = new Pagination(20, 20, 10);
        $pages      = $pagination->getPages();
        $this->assertCount(2, $pages);
        $this->assertContains(1, $pages);
        $this->assertContains(2, $pages);
    }
}
