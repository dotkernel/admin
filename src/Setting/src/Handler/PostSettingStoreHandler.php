<?php

declare(strict_types=1);

namespace Admin\Setting\Handler;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Service\AdminService;
use Admin\App\Message;
use Admin\Setting\Entity\Setting;
use Admin\Setting\Enum\SettingEnum;
use Admin\Setting\InputFilter\Input\SettingValueInput;
use Admin\Setting\InputFilter\SettingInputFilter;
use Admin\Setting\Service\SettingService;
use Dot\DependencyInjection\Attribute\Inject;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function assert;
use function is_array;
use function json_decode;

class PostSettingStoreHandler implements RequestHandlerInterface
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
        $data       = json_decode($request->getBody()->getContents(), true);
        $identifier = $request->getAttribute('identifier');
        $value      = $data['value'] ?? null;

        $inputFilter = new SettingInputFilter();
        $inputFilter->add(new SettingValueInput('value', true));
        $inputFilter->setData([
            'identifier' => $identifier,
            'value'      => $value,
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
        if ($setting instanceof Setting) {
            $setting = $this->settingService->updateSetting($setting, $value);
        } else {
            $setting = $this->settingService->createSetting($admin, $identifier, $value);
        }

        return new JsonResponse([
            'data' => $setting->getArrayCopy(),
        ]);
    }
}
