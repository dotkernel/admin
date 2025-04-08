<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\User\Form\EditUserAvatarForm;
use Admin\User\Form\EditUserForm;
use Admin\User\Service\UserAvatarServiceInterface;
use Admin\User\Service\UserServiceInterface;
use Core\App\Exception\IdentityException;
use Core\App\Exception\NotFoundException;
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

use function array_merge;

class PostUserAvatarEditHandler implements RequestHandlerInterface
{
    #[Inject(
        UserServiceInterface::class,
        UserAvatarServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        EditUserForm::class,
        EditUserAvatarForm::class,
        'dot-log.default_logger',
    )]
    public function __construct(
        protected UserServiceInterface $userService,
        protected UserAvatarServiceInterface $userAvatarService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected EditUserForm $editUserForm,
        protected EditUserAvatarForm $editUserAvatarForm,
        protected Logger $logger,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $user = $this->userService->find($request->getAttribute('uuid'));
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $this->editUserAvatarForm
            ->setAttribute(
                'action',
                $this->router->generateUri('user::user-avatar-edit', ['uuid' => $user->getUuid()->toString()])
            );

        $this->editUserForm
            ->setAttribute(
                'action',
                $this->router->generateUri('user::user-edit', ['uuid' => $user->getUuid()->toString()])
            );

        try {
            $this->editUserAvatarForm->setData(array_merge($request->getParsedBody(), $request->getUploadedFiles()));
            if ($this->editUserAvatarForm->isValid()) {
                $this->userAvatarService->createAvatar(
                    $user,
                    $this->editUserAvatarForm->getInputFilter()->getValue('name')
                );
                $this->messenger->addSuccess(Message::USER_AVATAR_UPDATED);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            }

            return new HtmlResponse(
                $this->template->render('user::user-edit-form', [
                    'userAvatarEditForm' => $this->editUserAvatarForm->prepare(),
                    'userEditForm'       => $this->editUserForm->prepare(),
                    'activeTab'          => 'avatar',
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (IdentityException $exception) {
            return new HtmlResponse(
                $this->template->render('user::user-edit-form', [
                    'userAvatarEditForm' => $this->editUserAvatarForm->prepare(),
                    'userEditForm'       => $this->editUserForm->prepare(),
                    'activeTab'          => 'avatar',
                    'messages'           => [
                        'error' => $exception->getMessage(),
                    ],
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $exception) {
            $this->logger->err('Update user avatar', [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);
            $this->messenger->addError(Message::AN_ERROR_OCCURRED);

            return new EmptyResponse(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
