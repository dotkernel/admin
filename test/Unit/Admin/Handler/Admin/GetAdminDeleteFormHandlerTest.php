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
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class GetAdminDeleteFormHandlerTest extends UnitTest
{
    private MockObject&AdminServiceInterface $adminService;
    private MockObject&RouterInterface $router;
    private MockObject&TemplateRendererInterface $template;
    private MockObject&DeleteAdminForm $form;
    private MockObject&ServerRequestInterface $request;
    private MockObject&FlashMessengerInterface $messenger;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService = $this->createMock(AdminServiceInterface::class);
        $this->router       = $this->createMock(RouterInterface::class);
        $this->template     = $this->createMock(TemplateRendererInterface::class);
        $this->form         = $this->createMock(DeleteAdminForm::class);
        $this->request      = $this->createMock(ServerRequestInterface::class);
        $this->messenger    = $this->createMock(FlashMessengerInterface::class);
    }

    public function testInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->request->method('getAttribute')->with('id')->willReturn('test');
        $this->adminService->method('findAdmin')->willThrowException(new NotFoundException(Message::ADMIN_NOT_FOUND));

        $this->messenger->expects($this->once())->method('addError')->with(Message::ADMIN_NOT_FOUND);

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
        $id    = $this->createMock(Uuid::class);
        $admin = $this->createMock(Admin::class);

        $id->method('toString')->willReturn('0x123');
        $admin->method('getId')->willReturn($id);

        $this->request->method('getAttribute')->with('id')->willReturn($id->toString());
        $this->adminService->method('findAdmin')->with($id->toString())->willReturn($admin);

        $this->form->method('setAttribute')->willReturn(null);
        $this->router->method('generateUri')->willReturn('/');
        $this->template->method('render')->willReturn('<p></p>');

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
