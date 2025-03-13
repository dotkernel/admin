<?php

declare(strict_types=1);

namespace Admin\Setting\Handler;

use Admin\App\Message;
use Admin\Setting\Entity\Setting;
use Admin\Setting\Enum\SettingEnum;
use Admin\Setting\InputFilter\SettingInputFilter;
use Admin\Setting\Service\SettingService;
use Core\Admin\Entity\Admin;
use Core\Admin\Service\AdminService;
use Dot\DependencyInjection\Attribute\Inject;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function assert;
use function is_array;

class GetSettingViewHandler implements RequestHandlerInterface
{
    #[Inject(
        AuthenticationServiceInterface::class,
        AdminService::class,
        SettingService::class,
    )]
    public function __construct(
        protected AuthenticationServiceInterface $authenticationService,
        protected AdminService $adminService,
        protected SettingService $settingService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $identifier  = $request->getAttribute('identifier');
        $inputFilter = new SettingInputFilter();
        $inputFilter->setData([
            'identifier' => $identifier,
        ]);

        if (! $inputFilter->isValid()) {
            $messages = $inputFilter->getMessages();
            return new JsonResponse([
                'error' => [
                    'messages' => is_array($messages) ? $messages : [$messages],
                ],
            ], StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $admin = $this->adminService->getAdminRepository()->findOneBy([
            'uuid' => $this->authenticationService->getIdentity()->getUuid(),
        ]);

        if (! $admin instanceof Admin) {
            return new JsonResponse([
                'error' => [
                    'messages' => [
                        Message::ADMIN_NOT_FOUND,
                    ],
                ],
            ], StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $identifier = SettingEnum::tryFrom($identifier);
        assert($identifier instanceof SettingEnum);

        $setting = $this->settingService->findOneBy(['admin' => $admin, 'identifier' => $identifier]);

        if (! $setting instanceof Setting) {
            return new JsonResponse([
                'error' => [
                    'messages' => [
                        Message::SETTING_NOT_FOUND,
                    ],
                ],
            ], StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        return new JsonResponse([
            'data' => $setting->getArrayCopy(),
        ]);
    }
}
