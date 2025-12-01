<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\EditAdminForm;
use Admin\Admin\Handler\Admin\GetEditAdminFormHandler;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Enum\AdminStatusEnum;
use Core\App\Message;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Form\Exception\ExceptionInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class GetAdminEditFormHandlerTest extends UnitTest
{
    private MockObject&AdminServiceInterface $adminService;
    private MockObject&AdminRoleServiceInterface $adminRoleService;
    private MockObject&RouterInterface $router;
    private MockObject&TemplateRendererInterface $template;
    private MockObject&FlashMessengerInterface $messenger;
    private MockObject&EditAdminForm $form;
    private MockObject&ServerRequestInterface $request;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService     = $this->createMock(AdminServiceInterface::class);
        $this->adminRoleService = $this->createMock(AdminRoleServiceInterface::class);
        $this->router           = $this->createMock(RouterInterface::class);
        $this->template         = $this->createMock(TemplateRendererInterface::class);
        $this->messenger        = $this->createMock(FlashMessengerInterface::class);
        $this->form             = $this->createMock(EditAdminForm::class);
        $this->request          = $this->createMock(ServerRequestInterface::class);
    }

    public function testInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->request->method('getAttribute')->with('id')->willReturn('test');
        $this->adminService->method('findAdmin')->willThrowException(new NotFoundException(Message::ADMIN_NOT_FOUND));

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::ADMIN_NOT_FOUND);

        $handler = new GetEditAdminFormHandler(
            $this->adminService,
            $this->adminRoleService,
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
     * @throws ExceptionInterface
     */
    public function testValidAdminWillReturnHtmlTemplate(): void
    {
        $id    = $this->createMock(Uuid::class);
        $admin = $this->createMock(Admin::class);

        $id->method('toString')->willReturn('0x123');
        $admin->method('getId')->willReturn($id);
        $admin->method('getStatus')->willReturn(AdminStatusEnum::Active);

        $this->form->method('setAttribute')->willReturn($this->form);
        $this->form->method('bind')->willReturn($this->form);
        $this->request->method('getAttribute')->with('id')->willReturn($id->toString());
        $this->adminService->method('findAdmin')->with($id->toString())->willReturn($admin);

        $this->template->method('render')->willReturn('<p></p>');

        $handler = new GetEditAdminFormHandler(
            $this->adminService,
            $this->adminRoleService,
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
