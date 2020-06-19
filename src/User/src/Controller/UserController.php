<?php

namespace Frontend\User\Controller;

use Dot\AnnotatedServices\Annotation\Inject;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Frontend\Plugin\FormsPlugin;
use Frontend\User\Service\UserService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class UserController
 * @package Frontend\User\Controller
 */
class UserController extends AbstractActionController
{
    /** @var RouterInterface $router */
    protected RouterInterface $router;

    /** @var TemplateRendererInterface $template */
    protected TemplateRendererInterface $template;

    /** @var UserService $userService */
    protected UserService $userService;

    /** @var AuthenticationServiceInterface $authenticationService */
    protected AuthenticationServiceInterface $authenticationService;

    /** @var FlashMessenger $messenger */
    protected FlashMessenger $messenger;

    /** @var FormsPlugin $forms */
    protected FormsPlugin $forms;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @Inject({
     *     UserService::class,
     *     RouterInterface::class,
     *     TemplateRendererInterface::class,
     *     AuthenticationService::class,
     *     FlashMessenger::class,
     *     FormsPlugin::class
     *     })
     */
    public function __construct(
        UserService $userService,
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService,
        FlashMessenger $messenger,
        FormsPlugin $forms
    ) {
        $this->userService = $userService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
    }
}
