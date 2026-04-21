<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\DeleteAdminForm;
use Admin\Admin\Handler\Admin\GetDeleteAdminFormHandler;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\App\Message;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class GetAdminDeleteFormHandlerTest extends UnitTest
{
    private Stub&AdminServiceInterface $adminService;
    private Stub&RouterInterface $router;
    private Stub&TemplateRendererInterface $template;
    private Stub&DeleteAdminForm $form;
    private Stub&ServerRequestInterface $request;
    private MockObject&FlashMessengerInterface $messenger;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService = $this->createStub(AdminServiceInterface::class);
        $this->router       = $this->createStub(RouterInterface::class);
        $this->template     = $this->createStub(TemplateRendererInterface::class);
        $this->form         = $this->createStub(DeleteAdminForm::class);
        $this->request      = $this->createStub(ServerRequestInterface::class);
        $this->messenger    = $this->createMock(FlashMessengerInterface::class);
    }

    public function testInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->request->method('getAttribute')->willReturn('test');
        $this->adminService->method('findAdmin')->willThrowException(new NotFoundException(Message::ADMIN_NOT_FOUND));

        $this->messenger->expects($this->once())->method('addError');

        $handler = new GetDeleteAdminFormHandler(
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
        $id    = $this->createStub(Uuid::class);
        $admin = $this->createStub(Admin::class);

        $id->method('toString')->willReturn('0x123');
        $admin->method('getId')->willReturn($id);

        $this->request->method('getAttribute')->willReturn($id->toString());
        $this->adminService->method('findAdmin')->willReturn($admin);

        $this->form->method('setAttribute')->willReturn(null);
        $this->router->method('generateUri')->willReturn('/');
        $this->template->method('render')->willReturn('<p></p>');
        $this->messenger->expects($this->never())->method('addError');

        $handler = new GetDeleteAdminFormHandler(
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
