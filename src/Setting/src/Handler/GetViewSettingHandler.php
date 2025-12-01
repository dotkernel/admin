<?php

declare(strict_types=1);

namespace Admin\Setting\Handler;

use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use Admin\Setting\Service\SettingServiceInterface;
use Core\App\Message;
use Core\Setting\Entity\Setting;
use Core\Setting\Enum\SettingIdentifierEnum;
use Dot\DependencyInjection\Attribute\Inject;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetViewSettingHandler implements RequestHandlerInterface
{
    #[Inject(
        AuthenticationServiceInterface::class,
        AdminServiceInterface::class,
        SettingServiceInterface::class,
    )]
    public function __construct(
        protected AuthenticationServiceInterface $authenticationService,
        protected AdminServiceInterface $adminService,
        protected SettingServiceInterface $settingService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $identifier = SettingIdentifierEnum::tryFrom($request->getAttribute('identifier'));
        if (! $identifier instanceof SettingIdentifierEnum) {
            return new JsonResponse([
                'error' => [
                    'messages' => [
                        Message::settingNotFound($request->getAttribute('identifier')),
                    ],
                ],
            ], StatusCodeInterface::STATUS_NOT_FOUND);
        }

        try {
            $admin = $this->adminService->findAdmin($this->authenticationService->getIdentity()->getId());
        } catch (NotFoundException $exception) {
            return new JsonResponse([
                'error' => [
                    'messages' => [
                        $exception->getMessage(),
                    ],
                ],
            ], StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $setting = $this->settingService->findOneBy(['admin' => $admin, 'identifier' => $identifier]);
        if (! $setting instanceof Setting) {
            return new JsonResponse([
                'error' => [
                    'messages' => [
                        Message::settingNotFound($identifier->value),
                    ],
                ],
            ], StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        return new JsonResponse([
            'data' => $setting->getArrayCopy(),
        ]);
    }
}
