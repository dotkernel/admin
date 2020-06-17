<?php

namespace Frontend\App\Controller;

use Dot\AnnotatedServices\Annotation\Inject;
use Dot\Controller\AbstractActionController;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class DashboardController
 * @package Frontend\App\Controller
 */
class DashboardController extends AbstractActionController
{
    /** @var RouterInterface $router */
    protected RouterInterface $router;

    /** @var TemplateRendererInterface $template */
    protected TemplateRendererInterface $template;

    /** @var AuthenticationServiceInterface $authenticationService */
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
     * @return HtmlResponse|RedirectResponse
     */
    public function indexAction()
    {
        if (!$this->authenticationService->hasIdentity()) {
            return new RedirectResponse($this->router->generateUri('user', ['action' => 'login']));
        }

        return new HtmlResponse($this->template->render('app::dashboard'));
    }
}
