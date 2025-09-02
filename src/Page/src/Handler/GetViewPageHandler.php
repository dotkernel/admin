<?php

declare(strict_types=1);

namespace Admin\Page\Handler;

use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetViewPageHandler implements RequestHandlerInterface
{
    #[Inject(
        TemplateRendererInterface::class,
    )]
    public function __construct(
        protected TemplateRendererInterface $template,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $template = $request->getAttribute(RouteResult::class)->getMatchedRouteName();

        return new HtmlResponse(
            $this->template->render($template)
        );
    }
}
