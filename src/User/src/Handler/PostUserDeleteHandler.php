<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\App\Exception\NotFoundException;
use Admin\User\Form\DeleteUserForm;
use Admin\User\Service\UserAvatarServiceInterface;
use Admin\User\Service\UserServiceInterface;
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

class PostUserDeleteHandler implements RequestHandlerInterface
{
    #[Inject(
        UserServiceInterface::class,
        UserAvatarServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        DeleteUserForm::class,
        'dot-log.default_logger',
    )]
    public function __construct(
        protected UserServiceInterface $userService,
        protected UserAvatarServiceInterface $userAvatarService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected DeleteUserForm $deleteUserForm,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $user = $this->userService->findUser($request->getAttribute('uuid'));
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $this->deleteUserForm->setAttribute(
            'action',
            $this->router->generateUri('user::delete-user', ['uuid' => $user->getUuid()->toString()])
        );

        try {
            /** @var iterable<array<string, string|string[]>> $data */
            $data = $request->getParsedBody();
            $this->deleteUserForm->setData($data);
            if ($this->deleteUserForm->isValid()) {
                $this->userService->deleteUser($user);
                $this->userAvatarService->deleteAvatar($user);
                $this->messenger->addSuccess(Message::USER_DELETED);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            }

            return new HtmlResponse(
                $this->template->render('user::delete-user-form', [
                    'form' => $this->deleteUserForm->prepare(),
                    'user' => $user,
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $exception) {
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);
            $this->logger->err('Create user', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return new EmptyResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
