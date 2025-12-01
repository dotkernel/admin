<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\App\Exception\NotFoundException;
use Admin\App\Form\AbstractForm;
use Admin\User\Form\EditUserAvatarForm;
use Admin\User\Form\EditUserForm;
use Admin\User\Service\UserAvatarServiceInterface;
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
use Laminas\Form\Exception\ExceptionInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

use function array_filter;
use function array_map;
use function array_merge;

/**
 * @phpstan-import-type SelectDataType from AbstractForm
 */
class PostEditUserAvatarHandler implements RequestHandlerInterface
{
    #[Inject(
        UserServiceInterface::class,
        UserRoleServiceInterface::class,
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
        protected UserRoleServiceInterface $userRoleService,
        protected UserAvatarServiceInterface $userAvatarService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected EditUserForm $editUserForm,
        protected EditUserAvatarForm $editUserAvatarForm,
        protected Logger $logger,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $user = $this->userService->findUser($request->getAttribute('id'));
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        /** @var UserRole[] $userRoles */
        $userRoles = $this->userRoleService->getUserRoleRepository()->findAll();
        $userRoles = array_map(
        /** @return SelectDataType */
            fn (UserRole $userRole): array => [
                'label'    => $userRole->getName()->value,
                'value'    => $userRole->getId()->toString(),
                'selected' => $user->hasRole($userRole),
            ],
            $userRoles
        );
        $userRoles = array_filter($userRoles, fn (array $role) => $role['label'] !== UserRoleEnum::Guest->value);

        $this->editUserAvatarForm
            ->setAttribute(
                'action',
                $this->router->generateUri('user::edit-user-avatar', ['id' => $user->getId()->toString()])
            );

        $this->editUserForm
            ->setAttribute(
                'action',
                $this->router->generateUri('user::edit-user', ['id' => $user->getId()->toString()])
            );
        $this->editUserForm->setRoles($userRoles);
        try {
            $this->editUserAvatarForm->setData(
                array_merge((array) $request->getParsedBody(), $request->getUploadedFiles())
            );
            if ($this->editUserAvatarForm->isValid()) {
                $this->userAvatarService->createAvatar(
                    $user,
                    $this->editUserAvatarForm->getInputFilter()->getValue('name')
                );
                $this->messenger->addSuccess(Message::USER_AVATAR_UPDATED);

                return new EmptyResponse(StatusCodeInterface::STATUS_CREATED);
            }

            return new HtmlResponse(
                $this->template->render('user::edit-user-form', [
                    'userAvatarEditForm' => $this->editUserAvatarForm->prepare(),
                    'userEditForm'       => $this->editUserForm->prepare(),
                    'activeTab'          => 'avatar',
                    'user'               => $user,
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
