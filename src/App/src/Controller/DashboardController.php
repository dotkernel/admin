<?php

declare(strict_types=1);

namespace Frontend\App\Controller;

use Dot\AnnotatedServices\Annotation\Inject;
use Dot\Controller\AbstractActionController;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DashboardController
 * @package Frontend\App\Controller
 */
class DashboardController extends AbstractActionController
{
    protected RouterInterface $router;

    protected TemplateRendererInterface $template;

    protected AuthenticationServiceInterface $authenticationService;

    /**
     * DashboardController constructor.
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     *
     * @Inject({RouterInterface::class, TemplateRendererInterface::class, AuthenticationService::class})
     */
    public function __construct(
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService
    ) {
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return ResponseInterface
     */
    public function indexAction()
    {
        return new HtmlResponse($this->template->render('app::dashboard'));
    }
}
