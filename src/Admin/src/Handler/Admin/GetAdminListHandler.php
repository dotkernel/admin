<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Enum\AdminStatusEnum;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Common\ServerRequestAwareTrait;
use Admin\App\Pagination;
use Admin\Setting\Enum\SettingEnum;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAdminListHandler implements RequestHandlerInterface
{
    use ServerRequestAwareTrait;

    #[Inject(
        AdminServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
        AdminForm::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
        protected AdminForm $form,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = [
            'offset' => $this->getQueryParam($request, 'offset', 0, 'int'),
            'limit'  => $this->getQueryParam($request, 'limit', 10, 'int'),
            'sort'   => $this->getQueryParam($request, 'sort', 'created'),
            'order'  => $this->getQueryParam($request, 'order', 'desc'),
            'search' => $this->getQueryParam($request, 'search'),
            'status' => $this->getQueryParam($request, 'status'),
        ];

        $result = $this->adminService->getAdmins(
            $params['offset'],
            $params['limit'],
            $params['search'],
            $params['sort'],
            $params['order'],
        );

        $this->form->setAttribute('action', $this->router->generateUri('admin::admin-create'));

        return new HtmlResponse(
            $this->template->render('admin::list', [
                'params'     => $params,
                'admins'     => $result['rows'],
                'statuses'   => AdminStatusEnum::cases(),
                'identifier' => SettingEnum::IdentifierTableAdminListSelectedColumns->value,
                'form'       => $this->form->prepare(),
                'pagination' => new Pagination($result['total'], $result['offset'], $result['limit']),
            ])
        );
    }
}
