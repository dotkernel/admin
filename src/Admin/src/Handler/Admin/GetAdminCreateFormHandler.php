<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\CreateAdminForm;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAdminCreateFormHandler implements RequestHandlerInterface
{
    #[Inject(
        RouterInterface::class,
        TemplateRendererInterface::class,
        CreateAdminForm::class,
    )]
    public function __construct(
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected CreateAdminForm $createAdminForm,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->createAdminForm->setAttribute('action', $this->router->generateUri('admin::admin-create'));

        return new HtmlResponse(
            $this->template->render('admin::admin-create-form', [
                'form' => $this->createAdminForm->prepare(),
            ])
        );
    }
}
