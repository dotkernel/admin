<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\InputFilter\EditAdminInputFilter;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\IdentityException;
use Admin\App\Message;
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

class PostAdminEditHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        AdminForm::class,
        "dot-log.default_logger",
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected AdminForm $form,
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
                $this->router->generateUri('admin::admin-edit', ['uuid' => $admin->getUuid()->toString()])
            );

            $this->form->setInputFilter(new EditAdminInputFilter());
            $this->form->setData($request->getParsedBody());
            if ($this->form->isValid()) {
                /** @var array $result */
                $result = $this->form->getData();
                $this->adminService->updateAdmin($admin, $result);

                $this->messenger->addSuccess(Message::ADMIN_UPDATED_SUCCESSFULLY);
                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            } else {
                return new HtmlResponse(
                    $this->template->render('admin::edit-admin-modal-content', [
                        'form' => $this->form->prepare(),
                    ]),
                    StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
                );
            }
        } catch (IdentityException $exception) {
            return new HtmlResponse(
                $this->template->render('admin::edit-admin-modal-content', [
                    'form'     => $this->form->prepare(),
                    'messages' => [
                        'error' => $exception->getMessage(),
                    ],
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $e) {
            $this->logger->err(Message::UPDATE_ADMIN, [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
            return new EmptyResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
