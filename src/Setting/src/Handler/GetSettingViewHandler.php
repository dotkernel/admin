<?php

declare(strict_types=1);

namespace Admin\Setting\Handler;

use Admin\Admin\Service\AdminServiceInterface;
use Admin\Setting\InputFilter\CreateSettingInputFilter;
use Admin\Setting\Service\SettingServiceInterface;
use Core\App\Exception\NotFoundException;
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

use function assert;
use function is_array;

class GetSettingViewHandler implements RequestHandlerInterface
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
        $identifier  = $request->getAttribute('identifier');
        $inputFilter = (new CreateSettingInputFilter())->setData(['identifier' => $identifier]);
        if (! $inputFilter->isValid()) {
            $messages = $inputFilter->getMessages();
            return new JsonResponse([
                'error' => [
                    'messages' => is_array($messages) ? $messages : [$messages],
                ],
            ], StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        try {
            $admin = $this->adminService->find($this->authenticationService->getIdentity()->getUuid());
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
