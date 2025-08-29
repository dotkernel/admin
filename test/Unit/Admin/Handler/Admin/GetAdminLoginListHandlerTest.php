<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Handler\Admin\GetListAdminLoginHandler;
use Admin\Admin\Service\AdminLoginServiceInterface;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

class GetAdminLoginListHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testListAdminLoginsWillReturnHtmlResponse(): void
    {
        $adminLoginService = $this->createMock(AdminLoginServiceInterface::class);
        $template          = $this->createMock(TemplateRendererInterface::class);
        $request           = $this->createMock(ServerRequestInterface::class);

        $request->method('getQueryParams')->willReturn([]);
        $adminLoginService->method('getAdminLogins')->willReturn([]);

        $handler  = new GetListAdminLoginHandler($adminLoginService, $template);
        $response = $handler->handle($request);

        $this->assertSame($response->getHeaderLine('content-type'), 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
