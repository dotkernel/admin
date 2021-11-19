<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\User\Controller\AdminController;
use Frontend\User\Form\AdminForm;
use Frontend\User\Service\AdminService;
use Frontend\User\Service\UserService;
use Laminas\Authentication\AuthenticationService;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AdminControllerFactory
 * @package Frontend\User\Factory
 */
class AdminControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @return AdminController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $userService = $container->get(UserService::class);
        $adminService = $container->get(AdminService::class);
        $messenger = $container->get(FlashMessenger::class);
        $auth = $container->get(AuthenticationService::class);
        $forms = $container->get(FormsPlugin::class);
        $adminForm = $container->get(AdminForm::class);

        return new AdminController(
            $userService,
            $adminService,
            $router,
            $template,
            $auth,
            $messenger,
            $forms,
            $adminForm
        );
    }
}
