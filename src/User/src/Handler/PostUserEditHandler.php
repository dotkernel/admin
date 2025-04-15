<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Admin\User\Form\EditUserAvatarForm;
use Admin\User\Form\EditUserForm;
use Admin\User\Service\UserRoleServiceInterface;
use Admin\User\Service\UserServiceInterface;
use Core\App\Message;
use Core\User\Entity\UserRole;
use Core\User\Enum\UserRoleEnum;
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

use function array_filter;
use function array_map;

class PostUserEditHandler implements RequestHandlerInterface
{
    #[Inject(
        UserServiceInterface::class,
        UserRoleServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        EditUserForm::class,
        EditUserAvatarForm::class,
        'dot-log.default_logger',
    )]
    public function __construct(
        protected UserServiceInterface $userService,
        protected UserRoleServiceInterface $userRoleService,
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
            $user = $this->userService->findUser($request->getAttribute('uuid'));
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $userRoles = array_map(fn (UserRole $userRole): array => [
            'label'    => $userRole->getName()->value,
            'value'    => $userRole->getUuid()->toString(),
            'selected' => $user->hasRole($userRole),
        ], $this->userRoleService->getUserRoleRepository()->findAll());
        $userRoles = array_filter($userRoles, fn (array $role) => $role['label'] !== UserRoleEnum::Guest->value);

        $this->editUserAvatarForm
            ->setAttribute(
                'action',
                $this->router->generateUri('user::user-avatar-edit', ['uuid' => $user->getUuid()->toString()])
            );

        $this->editUserForm
            ->setAttribute(
                'action',
                $this->router->generateUri('user::user-edit', ['uuid' => $user->getUuid()->toString()])
            )
            ->setRoles($userRoles);

        try {
            $this->editUserForm->setData($request->getParsedBody());
            if ($this->editUserForm->isValid()) {
                $this->userService->saveUser((array) $this->editUserForm->getData(), $user);
                $this->messenger->addSuccess(Message::USER_UPDATED);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            }

            return new HtmlResponse(
                $this->template->render('user::user-edit-form', [
                    'userAvatarEditForm' => $this->editUserAvatarForm->prepare(),
                    'userEditForm'       => $this->editUserForm->prepare(),
                    'activeTab'          => 'account',
                    'user'               => $user,
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (BadRequestException | ConflictException | NotFoundException $exception) {
            return new HtmlResponse(
                $this->template->render('user::user-edit-form', [
                    'userAvatarEditForm' => $this->editUserAvatarForm->prepare(),
                    'userEditForm'       => $this->editUserForm->prepare(),
                    'activeTab'          => 'account',
                    'messages'           => [
                        'error' => $exception->getMessage(),
                    ],
                    'user'               => $user,
                ]),
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $exception) {
            $this->logger->err('Update user', [
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
