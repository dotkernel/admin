<?php

declare(strict_types=1);

namespace Admin\User\Handler;

use Admin\User\Service\UserServiceInterface;
use Core\Setting\Enum\SettingIdentifierEnum;
use Core\User\Enum\UserRoleEnum;
use Core\User\Enum\UserStatusEnum;
use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetUserListHandler implements RequestHandlerInterface
{
    #[Inject(
        UserServiceInterface::class,
        TemplateRendererInterface::class,
    )]
    public function __construct(
        protected UserServiceInterface $userService,
        protected TemplateRendererInterface $template,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('user::list-user', [
                'pagination' => $this->userService->getUsers($request->getQueryParams()),
                'statuses'   => UserStatusEnum::validCases(),
                'roles'      => UserRoleEnum::validCases(),
                'identifier' => SettingIdentifierEnum::IdentifierTableUserListSelectedColumns->value,
            ])
        );
    }
}
