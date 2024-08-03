<?php

declare(strict_types=1);

namespace Admin\App\Controller;

use Admin\App\Common\ServerRequestAwareTrait;
use Dot\Controller\AbstractActionController;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

class PageController extends AbstractActionController
{
    use ServerRequestAwareTrait;

    #[Inject(
        RouterInterface::class,
        TemplateRendererInterface::class,
    )]
    public function __construct(protected RouterInterface $router, protected TemplateRendererInterface $template)
    {
    }

    public function componentsAction(): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::components'));
    }
}
