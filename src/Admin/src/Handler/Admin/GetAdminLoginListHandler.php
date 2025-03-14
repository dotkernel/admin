<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\App\Pagination;
use Admin\Setting\Enum\SettingEnum;
use Core\Admin\Enum\SuccessFailureEnum;
use Core\Admin\Service\AdminServiceInterface;
use Core\App\Common\ServerRequestAwareTrait;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAdminLoginListHandler implements RequestHandlerInterface
{
    use ServerRequestAwareTrait;

    #[Inject(
        AdminServiceInterface::class,
        TemplateRendererInterface::class,
        AuthenticationServiceInterface::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected TemplateRendererInterface $template,
        protected AuthenticationServiceInterface $authenticationService,
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

        return new HtmlResponse(
            $this->template->render('admin::list-logins', [
                'params'     => $params,
                'logins'     => $logins['rows'],
                'statuses'   => SuccessFailureEnum::values(),
                'identities' => $this->adminService->getAdminLoginIdentities(),
                'identifier' => SettingEnum::IdentifierTableAdminListLoginsSelectedColumns->value,
                'pagination' => new Pagination($logins['total'], $params['offset'], $params['limit']),
            ])
        );
    }
}
