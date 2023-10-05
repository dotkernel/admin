<?php

declare(strict_types=1);

namespace Frontend\App\Controller;

use Dot\AnnotatedServices\Annotation\Inject;
use Dot\Controller\AbstractActionController;
use Frontend\App\Common\ServerRequestAwareTrait;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

class DashboardController extends AbstractActionController
{
    use ServerRequestAwareTrait;

    /**
     * @Inject({
     *     RouterInterface::class,
     *     TemplateRendererInterface::class,
     *     AuthenticationServiceInterface::class
     * })
     */
    public function __construct(
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService
    ) {
    }

    public function indexAction(): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::dashboard'));
    }
}
