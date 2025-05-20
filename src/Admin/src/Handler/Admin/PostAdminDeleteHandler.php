<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\DeleteAdminForm;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use Core\App\Message;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Log\Logger;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostAdminDeleteHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        DeleteAdminForm::class,
        'dot-log.default_logger',
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected DeleteAdminForm $deleteAdminForm,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $admin = $this->adminService->findAdmin($request->getAttribute('uuid'));
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $this->deleteAdminForm->setAttribute(
            'action',
            $this->router->generateUri('admin::admin-delete', ['uuid' => $admin->getUuid()->toString()])
        );

        try {
            /** @var iterable<array<string, string|string[]>> $data */
            $data = $request->getParsedBody();
            $this->deleteAdminForm->setData($data);
            if ($this->deleteAdminForm->isValid()) {
                $this->adminService->deleteAdmin($admin);
                $this->messenger->addSuccess(Message::ADMIN_DELETED);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            }

            return new HtmlResponse(
                $this->template->render('admin::admin-delete-form', [
                    'form'  => $this->deleteAdminForm->prepare(),
                    'admin' => $admin,
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $exception) {
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
            $this->logger->err('Delete admin', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return new EmptyResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
