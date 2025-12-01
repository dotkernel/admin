<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\App\Exception\NotFoundException;
use Admin\User\Form\DeleteUserForm;
use Admin\User\Service\UserServiceInterface;
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

class GetDeleteUserFormHandler implements RequestHandlerInterface
{
    #[Inject(
        UserServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        FlashMessengerInterface::class,
        DeleteUserForm::class,
    )]
    public function __construct(
        protected UserServiceInterface $userService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected FlashMessengerInterface $messenger,
        protected DeleteUserForm $deleteUserForm,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $user = $this->userService->findUser($request->getAttribute('id'));
        } catch (NotFoundException $exception) {
            $this->messenger->addError($exception->getMessage());

            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $this->deleteUserForm->setAttribute(
            'action',
            $this->router->generateUri('user::delete-user', ['id' => $user->getId()->toString()])
        );

        return new HtmlResponse(
            $this->template->render('user::delete-user-form', [
                'form' => $this->deleteUserForm->prepare(),
                'user' => $user,
            ]),
        );
    }
}
