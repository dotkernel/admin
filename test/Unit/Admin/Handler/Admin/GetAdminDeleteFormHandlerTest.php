<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\AdminDeleteForm;
use Admin\Admin\Handler\Admin\GetAdminDeleteFormHandler;
use Admin\App\Message;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Service\AdminServiceInterface;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class GetAdminDeleteFormHandlerTest extends UnitTest
{
    private MockObject|AdminServiceInterface $adminService;
    private MockObject|RouterInterface $router;
    private MockObject|TemplateRendererInterface $template;
    private MockObject|AdminDeleteForm $form;
    private MockObject|ServerRequestInterface $request;
    private MockObject|FlashMessengerInterface $messenger;
    private MockObject|AdminRepository $adminRepository;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService    = $this->createMock(AdminServiceInterface::class);
        $this->router          = $this->createMock(RouterInterface::class);
        $this->template        = $this->createMock(TemplateRendererInterface::class);
        $this->form            = $this->createMock(AdminDeleteForm::class);
        $this->request         = $this->createMock(ServerRequestInterface::class);
        $this->messenger       = $this->createMock(FlashMessengerInterface::class);
        $this->adminRepository = $this->createMock(AdminRepository::class);
    }

    public function testInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->adminRepository->method('findOneBy')->willReturn(null);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);

        $this->messenger->expects($this->once())->method('addError')->with(Message::ADMIN_NOT_FOUND);

        $handler = new GetAdminDeleteFormHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testValidAdminWillReturnHtmlTemplate(): void
    {
        $uuid  = $this->createMock(Uuid::class);
        $admin = $this->createMock(Admin::class);

        $uuid->method('toString')->willReturn('0x123');
        $admin->method('getUuid')->willReturn($uuid);

        $this->adminRepository->method('findOneBy')->willReturn($admin);

        $this->form->method('setAttribute')->willReturn(null);
        $this->router->method('generateUri')->willReturn('/');
        $this->template->method('render')->willReturn('<p></p>');
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);

        $handler = new GetAdminDeleteFormHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
        );

        $response = $handler->handle($this->request);

        $this->assertSame($response->getHeader('content-type')[0], 'text/html; charset=utf-8');
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
