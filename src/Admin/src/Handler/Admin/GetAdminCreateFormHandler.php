<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Form\AdminForm;
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
        AdminForm::class,
    )]
    public function __construct(
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AdminForm $form,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->form->setAttribute('action', $this->router->generateUri('admin::admin-create'));

        return new HtmlResponse(
            $this->template->render('admin::admin-create-form', [
                'form' => $this->form->prepare(),
            ])
        );
    }
}
