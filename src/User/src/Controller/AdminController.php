<?php

namespace Frontend\User\Controller;

use Dot\AnnotatedServices\Annotation\Inject;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Fig\Http\Message\RequestMethodInterface;
use Frontend\Plugin\FormsPlugin;
use Frontend\User\Form\LoginForm;
use Frontend\User\Service\UserService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AdminController
 * @package Frontend\User\Controller
 */
class AdminController extends AbstractActionController
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

    /**
     * @return HtmlResponse
     */
    public function manageAction()
    {
        return new HtmlResponse($this->template->render('admin::admin-list'));
    }

    /**
     * @return ResponseInterface
     */
    public function loginAction(): ResponseInterface
    {
        if ($this->authenticationService->hasIdentity()) {
            return new RedirectResponse($this->router->generateUri("dashboard"));
        }

        /** @var LoginForm $form */
        $form = new LoginForm();

        $shouldRebind = $this->messenger->getData('shouldRebind') ?? true;
        if ($shouldRebind) {
            $this->forms->restoreState($form);
        }

        if (RequestMethodInterface::METHOD_POST === $this->getRequest()->getMethod()) {
            $form->setData($this->getRequest()->getParsedBody());
            if ($form->isValid()) {
                $adapter = $this->authenticationService->getAdapter();
                $data = $form->getData();
                $adapter->setIdentity($data['username']);
                $adapter->setCredential($data['password']);
                $authResult = $this->authenticationService->authenticate();
                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $this->authenticationService->getStorage()->write($identity);

                    return new RedirectResponse($this->router->generateUri('dashboard'));
                } else {
                    $this->messenger->addData('shouldRebind', true);
                    $this->forms->saveState($form);
                    $this->messenger->addError($authResult->getMessages(), 'user-login');
                    return new RedirectResponse($this->getRequest()->getUri(), 303);
                }
            } else {
                $this->messenger->addData('shouldRebind', true);
                $this->forms->saveState($form);
                $this->messenger->addError($this->forms->getMessages($form), 'user-login');
                return new RedirectResponse($this->getRequest()->getUri(), 303);
            }
        }

        return new HtmlResponse(
            $this->template->render('user::login', [
                'form' => $form
            ])
        );
    }

    /**
     * @return ResponseInterface
     */
    public function logoutAction(): ResponseInterface
    {
        $this->authenticationService->clearIdentity();
        return new RedirectResponse(
            $this->router->generateUri('admin', ['action' => 'login'])
        );
    }
}
