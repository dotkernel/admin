<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\CreateAdminForm;
use Admin\Admin\InputFilter\CreateAdminInputFilter;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\ConflictException;
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

/**
 * @phpstan-import-type CreateAdminDataType from CreateAdminInputFilter
 */
class PostAdminCreateHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        CreateAdminForm::class,
        'dot-log.default_logger',
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected CreateAdminForm $createAdminForm,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->createAdminForm->setAttribute('action', $this->router->generateUri('admin::admin-create'));

        try {
            /** @var iterable<array<string, string|string[]>> $data */
            $data = $request->getParsedBody();
            $this->createAdminForm->setData($data);
            if ($this->createAdminForm->isValid()) {
                /** @var CreateAdminDataType $data */
                $data = $this->createAdminForm->getData();
                $this->adminService->saveAdmin($data);
                $this->messenger->addSuccess(Message::ADMIN_CREATED);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            }

            return new HtmlResponse(
                $this->template->render('admin::admin-create-form', [
                    'form' => $this->createAdminForm->prepare(),
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (ConflictException $exception) {
            return new HtmlResponse(
                $this->template->render('admin::admin-create-form', [
                    'form'     => $this->createAdminForm->prepare(),
                    'messages' => [
                        'error' => $exception->getMessage(),
                    ],
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $exception) {
            $this->logger->err('Create admin', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return new HtmlResponse(
                $this->template->render('admin::admin-create-form', [
                    'form'     => $this->createAdminForm->prepare(),
                    'messages' => [
                        'error' => Message::AN_ERROR_OCCURRED,
                    ],
                ]),
                StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
            );
        }
    }
}
