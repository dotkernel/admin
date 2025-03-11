<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminIdentity;
use Admin\Admin\Handler\Admin\GetAdminLoginListHandler;
use Admin\Admin\Repository\AdminRepository;
use Admin\Admin\Service\AdminServiceInterface;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetAdminLoginListHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testListAdminWillReturnHtmlResponse(): void
    {
        $adminService          = $this->createMock(AdminServiceInterface::class);
        $template              = $this->createMock(TemplateRendererInterface::class);
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $adminRepository       = $this->createMock(AdminRepository::class);
        $request               = $this->createMock(ServerRequestInterface::class);

        $request->method('getQueryParams')->willReturn([]);
        $adminRepository->method('findOneBy')->willReturn($this->createMock(Admin::class));
        $adminService->method('getAdminLogins')->willReturn([
            'rows'   => [],
            'total'  => 1,
            'offset' => 1,
            'limit'  => 1,
        ]);

        $adminService->method('getAdminRepository')->willReturn($adminRepository);
        $authenticationService
            ->method('getIdentity')
            ->willReturn(
                $this->createMock(AdminIdentity::class)
            );

        $handler = new GetAdminLoginListHandler(
            $adminService,
            $template,
            $authenticationService,
        );

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
