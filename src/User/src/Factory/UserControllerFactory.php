<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Frontend\Plugin\FormsPlugin;
use Frontend\User\Controller\UserController;
use Frontend\User\Form\UserForm;
use Frontend\User\Service\UserService;
use Laminas\Authentication\AuthenticationService;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

/**
 * Class UserControllerFactory
 * @package Frontend\User\Factory
 */
class UserControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @return UserController
     */
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $UserService = $container->get(UserService::class);
        $messenger = $container->get(FlashMessenger::class);
        $auth = $container->get(AuthenticationService::class);
        $forms = $container->get(FormsPlugin::class);
        $userForm = $container->get(UserForm::class);

        return new UserController(
            $UserService,
            $router,
            $template,
            $auth,
            $messenger,
            $forms,
            $userForm
        );
    }
}
