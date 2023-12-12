<?php

declare(strict_types=1);

namespace Frontend\Setting\Controller;

use Dot\AnnotatedServices\Annotation\Inject;
use Dot\Controller\AbstractActionController;
use Fig\Http\Message\StatusCodeInterface;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Service\AdminService;
use Frontend\App\Common\ServerRequestAwareTrait;
use Frontend\App\Message;
use Frontend\Setting\Entity\Setting;
use Frontend\Setting\InputFilter\Input\SettingValueInputFilter;
use Frontend\Setting\InputFilter\SettingInputFilter;
use Frontend\Setting\Service\SettingService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;

use function is_array;
use function json_decode;

class SettingController extends AbstractActionController
{
    use ServerRequestAwareTrait;

    /**
     * @Inject({
     *     AuthenticationServiceInterface::class,
     *     RouterInterface::class,
     *     AdminService::class,
     *     SettingService::class,
     * })
     */
    public function __construct(
        protected AuthenticationServiceInterface $authenticationService,
        protected RouterInterface $router,
        protected AdminService $adminService,
        protected SettingService $settingService,
    ) {
    }

    public function storeSettingAction(): JsonResponse
    {
        if (! $this->isPost()) {
            return new JsonResponse([
                'error' => [
                    'messages' => [
                        [Message::METHOD_NOT_ALLOWED],
                    ],
                ],
            ], StatusCodeInterface::STATUS_METHOD_NOT_ALLOWED);
        }

        $data       = json_decode($this->getRequest()->getBody()->getContents(), true);
        $identifier = $this->getRequest()->getAttribute('identifier');
        $value      = $data['value'] ?? null;

        $inputFilter = new SettingInputFilter();
        $inputFilter->add(new SettingValueInputFilter('value', true));
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

        $admin = $this->adminService->findAdminBy([
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

    public function getSettingAction(): JsonResponse
    {
        if (! $this->isGet()) {
            return new JsonResponse([
                'error' => [
                    'messages' => [
                        [Message::METHOD_NOT_ALLOWED],
                    ],
                ],
            ], StatusCodeInterface::STATUS_METHOD_NOT_ALLOWED);
        }

        $identifier  = $this->getRequest()->getAttribute('identifier');
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

        $admin = $this->adminService->findAdminBy([
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
