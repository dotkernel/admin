<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Admin;

use Admin\Admin\Service\AdminServiceInterface;
use Core\Admin\Enum\AdminRoleEnum;
use Core\Admin\Enum\AdminStatusEnum;
use Core\Setting\Enum\SettingIdentifierEnum;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAdminListHandler implements RequestHandlerInterface
{
    #[Inject(
        AdminServiceInterface::class,
        TemplateRendererInterface::class,
    )]
    public function __construct(
        protected AdminServiceInterface $adminService,
        protected TemplateRendererInterface $template,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('admin::list-admin', [
                'pagination' => $this->adminService->getAdmins($request->getQueryParams()),
                'statuses'   => AdminStatusEnum::cases(),
                'roles'      => AdminRoleEnum::cases(),
                'identifier' => SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns->value,
            ])
        );
    }
}
