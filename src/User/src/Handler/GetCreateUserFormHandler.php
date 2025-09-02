<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\User\Form\CreateUserForm;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetCreateUserFormHandler implements RequestHandlerInterface
{
    #[Inject(
        RouterInterface::class,
        TemplateRendererInterface::class,
        CreateUserForm::class,
    )]
    public function __construct(
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected CreateUserForm $createUserForm,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->createUserForm->setAttribute('action', $this->router->generateUri('user::create-user'));

        return new HtmlResponse(
            $this->template->render('user::create-user-form', [
                'form' => $this->createUserForm->prepare(),
            ])
        );
    }
}
