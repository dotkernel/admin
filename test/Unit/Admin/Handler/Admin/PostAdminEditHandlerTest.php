<?php

declare(strict_types=1);

namespace AdminTest\Unit\Admin\Handler\Admin;

use Admin\Admin\Form\AdminForm;
use Admin\Admin\Handler\Admin\PostAdminEditHandler;
use Admin\App\Message;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Service\AdminServiceInterface;
use Core\App\Exception\IdentityException;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class PostAdminEditHandlerTest extends UnitTest
{
    private MockObject|AdminServiceInterface $adminService;
    private MockObject|RouterInterface $router;
    private MockObject|TemplateRendererInterface $template;
    private MockObject|FlashMessengerInterface $messenger;
    private MockObject|AdminForm $form;
    private Logger $logger;
    private MockObject|ServerRequestInterface $request;
    private MockObject|AdminRepository $adminRepository;
    private MockObject|Admin $admin;
    private MockObject|Uuid $uuid;

    /**
     * @throws MockObjectException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminService    = $this->createMock(AdminServiceInterface::class);
        $this->router          = $this->createMock(RouterInterface::class);
        $this->template        = $this->createMock(TemplateRendererInterface::class);
        $this->messenger       = $this->createMock(FlashMessengerInterface::class);
        $this->form            = $this->createMock(AdminForm::class);
        $this->request         = $this->createMock(ServerRequestInterface::class);
        $this->adminRepository = $this->createMock(AdminRepository::class);
        $this->admin           = $this->createMock(Admin::class);
        $this->uuid            = $this->createMock(Uuid::class);
        $this->logger          = new Logger([
            'writers' => [
                'FileWriter' => [
                    'name'     => 'null',
                    'priority' => Logger::ALERT,
                ],
            ],
        ]);
    }

    public function testEditAdminInvalidAdminProvidedWillReturnNotFoundResponse(): void
    {
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(true);
        $this->form->method('getData')->willReturn([]);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addError')
            ->with(Message::ADMIN_NOT_FOUND);

        $handler = new PostAdminEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testEditAdminValidFormDataProvidedWillFlashSuccessMessage(): void
    {
        $this->uuid->method('toString')->willReturn('0x123');
        $this->admin->method('getUuid')->willReturn($this->uuid);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);

        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(true);
        $this->form->method('getData')->willReturn([]);

        $this
            ->messenger
            ->expects($this->once())
            ->method('addSuccess')
            ->with(Message::ADMIN_UPDATED_SUCCESSFULLY);

        $this->adminService->expects($this->once())->method('updateAdmin');

        $handler = new PostAdminEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
    }

    /**
     * @throws MockObjectException
     */
    public function testEditAdminInvalidFormDataProvidedWillReturnHtmlResponse(): void
    {
        $this->uuid->method('toString')->willReturn('0x123');
        $this->admin->method('getUuid')->willReturn($this->uuid);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(false);
        $this->form->method('getData')->willReturn([]);

        $handler = new PostAdminEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testEditAdminThrowIdentityExceptionWillReturnHtmlResponse(): void
    {
        $this->uuid->method('toString')->willReturn('0x123');
        $this->admin->method('getUuid')->willReturn($this->uuid);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(false);
        $this->form->method('getData')->willReturn([]);

        $handler = new PostAdminEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $this->throwException(new IdentityException());

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testEditAdminThrowExceptionWillReturnHtmlResponse(): void
    {
        $this->uuid->method('toString')->willReturn('0x123');
        $this->admin->method('getUuid')->willReturn($this->uuid);
        $this->adminRepository->method('findOneBy')->willReturn($this->admin);
        $this->adminService->method('getAdminRepository')->willReturn($this->adminRepository);
        $this->request->method('getParsedBody')->willReturn(['test']);
        $this->form->method('isValid')->willReturn(false);
        $this->form->method('getData')->willReturn([]);

        $handler = new PostAdminEditHandler(
            $this->adminService,
            $this->router,
            $this->template,
            $this->messenger,
            $this->form,
            $this->logger
        );

        $this->throwException(new Exception());

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}
