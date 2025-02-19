<?php

declare(strict_types=1);

namespace Admin\App\Handler;

use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexHandler implements RequestHandlerInterface
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
        return new HtmlResponse($this->template->render('app::dashboard'));
    }
}
