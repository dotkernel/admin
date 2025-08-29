<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Handler\Admin\GetListAdminHandler;
use Admin\Admin\Service\AdminServiceInterface;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Repository\AdminRepository;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetAdminListHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testListAdminWillReturnHtmlResponse(): void
    {
        $adminService    = $this->createMock(AdminServiceInterface::class);
        $template        = $this->createMock(TemplateRendererInterface::class);
        $adminRepository = $this->createMock(AdminRepository::class);
        $request         = $this->createMock(ServerRequestInterface::class);

        $request->method('getQueryParams')->willReturn([]);
        $adminRepository->method('findOneBy')->willReturn($this->createMock(Admin::class));
        $adminService->method('getAdmins')->willReturn([
            'rows'   => [],
            'total'  => 1,
            'offset' => 1,
            'limit'  => 1,
        ]);

        $adminService->method('getAdminRepository')->willReturn($adminRepository);

        $handler = new GetListAdminHandler($adminService, $template);

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
