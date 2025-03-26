<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\AdminDeleteForm;
use Admin\App\Message;
use Core\Admin\Entity\Admin;
use Core\Admin\Service\AdminServiceInterface;
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
        AdminDeleteForm::class,
        "dot-log.default_logger",
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected AdminDeleteForm $form,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $admin = $this->adminService->getAdminRepository()->findOneBy([
                'uuid' => $request->getAttribute('uuid'),
            ]);

            if (! $admin instanceof Admin) {
                $this->messenger->addError(Message::ADMIN_NOT_FOUND);
                return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
            }

            $this->form->setAttribute(
                'action',
                $this->router->generateUri('admin::admin-delete', [
                    'uuid' => $admin->getUuid()->toString(),
                ])
            );

            $this->form->setData($request->getParsedBody());
            if ($this->form->isValid()) {
                $this->adminService->getAdminRepository()->deleteAdmin($admin);
                $this->messenger->addSuccess(Message::ADMIN_DELETED_SUCCESSFULLY);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            } else {
                return new HtmlResponse(
                    $this->template->render('admin::admin-delete-form', [
                        'form'  => $this->form->prepare(),
                        'admin' => $admin,
                    ]),
                    StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
                );
            }
        } catch (Throwable $e) {
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
            $this->logger->err(Message::DELETE_ADMIN, [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return new EmptyResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
