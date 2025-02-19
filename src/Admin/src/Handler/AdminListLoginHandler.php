<?php

declare(strict_types=1);

namespace Admin\Admin\Handler;

use Admin\Admin\Entity\AdminLogin;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Common\ServerRequestAwareTrait;
use Admin\App\Pagination;
use Admin\Setting\Entity\Setting;
use Admin\Setting\Service\SettingService;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AdminListLoginHandler implements RequestHandlerInterface
{
    use ServerRequestAwareTrait;

    #[Inject(
        AdminServiceInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
        SettingService::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
        protected SettingService $settingService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = [
            'offset'   => $this->getQueryParam($request, 'offset', 0, 'int'),
            'limit'    => $this->getQueryParam($request, 'limit', 10, 'int'),
            'sort'     => $this->getQueryParam($request, 'sort', 'created'),
            'order'    => $this->getQueryParam($request, 'order', 'desc'),
            'identity' => $this->getQueryParam($request, 'identity'),
            'status'   => $this->getQueryParam($request, 'status'),
        ];

        $logins = $this->adminService->getAdminLogins(
            $params['offset'],
            $params['limit'],
            $params['sort'],
            $params['order'],
            [
                'identity' => $params['identity'],
                'status'   => $params['status'],
            ]
        );

        $settings = $this->settingService->findOneBy([
            'admin'      => $this->adminService->getAdminRepository()->findOneBy([
                'identity' => $this->authenticationService->getIdentity()->getIdentity(),
            ]),
            'identifier' => Setting::IDENTIFIER_TABLE_ADMIN_LIST_LOGINS_SELECTED_COLUMNS,
        ]);

        return new HtmlResponse(
            $this->template->render('admin::list-logins', [
                'params'     => $params,
                'logins'     => $logins['rows'],
                'settings'   => $settings?->getValue() ?? [],
                'statuses'   => [AdminLogin::LOGIN_FAIL, AdminLogin::LOGIN_SUCCESS],
                'identities' => $this->adminService->getAdminLoginIdentities(),
                'identifier' => Setting::IDENTIFIER_TABLE_ADMIN_LIST_LOGINS_SELECTED_COLUMNS,
                'pagination' => new Pagination($logins['total'], $params['offset'], $params['limit']),
            ])
        );
    }
}
