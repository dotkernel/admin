<?php

declare(strict_types=1);

namespace Admin\Setting\Handler;

use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use Admin\Setting\InputFilter\CreateSettingInputFilter;
use Admin\Setting\InputFilter\Input\ValueInput;
use Admin\Setting\Service\SettingServiceInterface;
use Core\Setting\Entity\Setting;
use Core\Setting\Enum\SettingIdentifierEnum;
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

class PostStoreSettingHandler implements RequestHandlerInterface
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
        $data  = json_decode($request->getBody()->getContents(), true);
        $value = $data['value'] ?? null;

        $identifier  = $request->getAttribute('identifier');
        $inputFilter = (new CreateSettingInputFilter())
            ->add(new ValueInput('value', true))
            ->setData([
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

        try {
            $admin = $this->adminService->findAdmin($this->authenticationService->getIdentity()->getUuid());
        } catch (NotFoundException $exception) {
            return new JsonResponse([
                'error' => [
                    'messages' => [
                        $exception->getMessage(),
                    ],
                ],
            ], StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $identifier = SettingIdentifierEnum::tryFrom($identifier);
        assert($identifier instanceof SettingIdentifierEnum);

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
