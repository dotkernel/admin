<?php

declare(strict_types=1);

namespace Frontend\App\Controller;

use Dot\Controller\AbstractActionController;
use Dot\DependencyInjection\Attribute\Inject;
use Frontend\App\Common\ServerRequestAwareTrait;
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
