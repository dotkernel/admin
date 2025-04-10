<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Service\AdminLoginServiceInterface;
use Core\App\Enum\SuccessFailureEnum;
use Core\Setting\Enum\SettingIdentifierEnum;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAdminLoginListHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminLoginServiceInterface::class,
        TemplateRendererInterface::class,
    )]
    public function __construct(
        protected AdminLoginServiceInterface $adminLoginService,
        protected TemplateRendererInterface $template,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('admin::admin-login-list', [
                'pagination' => $this->adminLoginService->getAdminLogins($request->getQueryParams()),
                'statuses'   => SuccessFailureEnum::cases(),
                'identities' => $this->adminLoginService->getAdminLoginRepository()->getAdminLoginIdentities(),
                'identifier' => SettingIdentifierEnum::IdentifierTableAdminListLoginsSelectedColumns->value,
            ])
        );
    }
}
