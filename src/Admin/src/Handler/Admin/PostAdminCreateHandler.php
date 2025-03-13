<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\AdminForm;
use Admin\App\Message;
use Core\Admin\Service\AdminServiceInterface;
use Core\App\Exception\IdentityException;
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

class PostAdminCreateHandler implements RequestHandlerInterface
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
            $this->form->setAttribute('action', $this->router->generateUri('admin::admin-create'));
            $this->form->setData($request->getParsedBody());
            if ($this->form->isValid()) {
                /** @var array $result */
                $result = $this->form->getData();
                $this->adminService->createAdmin($result);
                $this->messenger->addSuccess(Message::ADMIN_CREATED_SUCCESSFULLY);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            } else {
                return new HtmlResponse(
                    $this->template->render('admin::create-admin-form', [
                        'form' => $this->form->prepare(),
                    ]),
                    StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
                );
            }
        } catch (IdentityException $e) {
            return new HtmlResponse(
                $this->template->render('admin::create-admin-form', [
                    'form'     => $this->form->prepare(),
                    'messages' => [
                        'error' => $e->getMessage(),
                    ],
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $e) {
            $this->logger->err(Message::CREATE_ADMIN, [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return new HtmlResponse(
                $this->template->render('admin::create-admin-form', [
                    'form'     => $this->form->prepare(),
                    'messages' => [
                        'error' => Message::AN_ERROR_OCCURRED,
                    ],
                ]),
                StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
            );
        }
    }
}
