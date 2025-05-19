<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\App\Exception\NotFoundException;
use Admin\App\Form\AbstractForm;
use Admin\User\Form\EditUserAvatarForm;
use Admin\User\Form\EditUserForm;
use Admin\User\Service\UserRoleServiceInterface;
use Admin\User\Service\UserServiceInterface;
use Core\User\Entity\UserRole;
use Core\User\Enum\UserRoleEnum;
use Dot\DependencyInjection\Attribute\Inject;
use Dot\FlashMessenger\FlashMessengerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_filter;
use function array_map;

/**
 * @phpstan-import-type SelectDataType from AbstractForm
 */
class GetUserEditFormHandler implements RequestHandlerInterface
{
    #[Inject(
        UserServiceInterface::class,
        UserRoleServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        EditUserForm::class,
        EditUserAvatarForm::class,
    )]
    public function __construct(
        protected UserServiceInterface $userService,
        protected UserRoleServiceInterface $userRoleService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected EditUserForm $editUserForm,
        protected EditUserAvatarForm $editUserAvatarForm,
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

        /** @var UserRole[] $userRoles */
        $userRoles = $this->userRoleService->getUserRoleRepository()->findAll();
        $userRoles = array_map(
            /** @return SelectDataType */
            fn (UserRole $userRole): array => [
                'label'    => $userRole->getName()->value,
                'value'    => $userRole->getUuid()->toString(),
                'selected' => $user->hasRole($userRole),
            ],
            $userRoles
        );
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
            ->bind($user)
            ->setRoles($userRoles);

        return new HtmlResponse(
            $this->template->render('user::user-edit-form', [
                'userAvatarEditForm' => $this->editUserAvatarForm->prepare(),
                'userEditForm'       => $this->editUserForm->prepare(),
                'activeTab'          => 'account',
                'user'               => $user,
            ])
        );
    }
}
