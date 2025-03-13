<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\AdminForm;
use Admin\Admin\Handler\Admin\GetAdminListHandler;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminIdentity;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Service\AdminServiceInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
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
        $adminService          = $this->createMock(AdminServiceInterface::class);
        $router                = $this->createMock(RouterInterface::class);
        $template              = $this->createMock(TemplateRendererInterface::class);
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $form                  = $this->createMock(AdminForm::class);
        $adminRepository       = $this->createMock(AdminRepository::class);
        $request               = $this->createMock(ServerRequestInterface::class);

        $request->method('getQueryParams')->willReturn([]);
        $adminRepository->method('findOneBy')->willReturn($this->createMock(Admin::class));
        $adminService->method('getAdmins')->willReturn([
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

        $handler = new GetAdminListHandler(
            $adminService,
            $router,
            $template,
            $authenticationService,
            $form,
        );

        $response = $handler->handle($request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
