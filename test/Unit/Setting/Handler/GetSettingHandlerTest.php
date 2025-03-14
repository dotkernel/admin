<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Handler;

use Admin\App\Message;
use Admin\Setting\Entity\Setting;
use Admin\Setting\Enum\SettingEnum;
use Admin\Setting\Handler\GetSettingViewHandler;
use Admin\Setting\Service\SettingService;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminIdentity;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Service\AdminService;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

use function json_decode;
use function sprintf;

class GetSettingHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $handler = new GetSettingViewHandler(
            $this->createMock(AuthenticationServiceInterface::class),
            $this->createMock(AdminService::class),
            $this->createMock(SettingService::class),
        );

        $this->assertInstanceOf(GetSettingViewHandler::class, $handler);
    }

    /**
     * @throws Exception
     */
    public function testInvalidIdentifierProvided(): void
    {
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $adminService          = $this->createMock(AdminService::class);
        $settingService        = $this->createMock(SettingService::class);
        $request               = $this->createMock(ServerRequestInterface::class);

        $handler = new GetSettingViewHandler(
            $authenticationService,
            $adminService,
            $settingService,
        );

        $request->method('getAttribute')->with('identifier')->willReturn('test');

        $response = $handler->handle($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
        $this->assertIsArray($data);
        $this->assertNotEmpty($data['error']['messages']['identifier']['notInArray']);
        $this->assertSame(
            sprintf(Message::INVALID_VALUE, 'identifier'),
            $data['error']['messages']['identifier']['notInArray']
        );
    }

    /**
     * @throws Exception
     */
    public function testInvalidAdminProvided(): void
    {
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $adminService          = $this->createMock(AdminService::class);
        $settingService        = $this->createMock(SettingService::class);
        $adminRepository       = $this->createMock(AdminRepository::class);
        $request               = $this->createMock(ServerRequestInterface::class);
        $identity              = $this->createMock(AdminIdentity::class);

        $identity->method('getUuid')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $adminRepository->method('findOneBy')->with(['uuid' => 'test'])->willReturn(null);
        $adminService->method('getAdminRepository')->willReturn($adminRepository);

        $request
            ->method('getAttribute')
            ->with('identifier')
            ->willReturn(SettingEnum::IdentifierTableAdminListSelectedColumns->value);

        $handler = new GetSettingViewHandler(
            $authenticationService,
            $adminService,
            $settingService,
        );

        $response = $handler->handle($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
        $this->assertIsArray($data);
        $this->assertNotEmpty($data['error']['messages'][0]);
        $this->assertSame(
            Message::ADMIN_NOT_FOUND,
            $data['error']['messages'][0]
        );
    }

    /**
     * @throws Exception
     */
    public function testInvalidSettingProvided(): void
    {
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $adminService          = $this->createMock(AdminService::class);
        $settingService        = $this->createMock(SettingService::class);
        $adminRepository       = $this->createMock(AdminRepository::class);
        $request               = $this->createMock(ServerRequestInterface::class);
        $identity              = $this->createMock(AdminIdentity::class);
        $admin                 = $this->createMock(Admin::class);

        $identity->method('getUuid')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $adminRepository->method('findOneBy')->with(['uuid' => 'test'])->willReturn($admin);
        $adminService->method('getAdminRepository')->willReturn($adminRepository);

        $request
            ->method('getAttribute')
            ->with('identifier')
            ->willReturn(SettingEnum::IdentifierTableAdminListSelectedColumns->value);

        $handler = new GetSettingViewHandler(
            $authenticationService,
            $adminService,
            $settingService,
        );

        $response = $handler->handle($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
        $this->assertIsArray($data);
        $this->assertNotEmpty($data['error']['messages'][0]);
        $this->assertSame(
            Message::SETTING_NOT_FOUND,
            $data['error']['messages'][0]
        );
    }

    /**
     * @throws Exception
     */
    public function testValidDataProvided(): void
    {
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $adminService          = $this->createMock(AdminService::class);
        $settingService        = $this->createMock(SettingService::class);
        $adminRepository       = $this->createMock(AdminRepository::class);
        $request               = $this->createMock(ServerRequestInterface::class);
        $identity              = $this->createMock(AdminIdentity::class);
        $admin                 = $this->createMock(Admin::class);
        $setting               = $this->createMock(Setting::class);

        $identity->method('getUuid')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $adminRepository->method('findOneBy')->with(['uuid' => 'test'])->willReturn($admin);
        $adminService->method('getAdminRepository')->willReturn($adminRepository);
        $setting->method('getArrayCopy')->willReturn([
            'identifier' => 'test',
            'value'      => 'test',
        ]);
        $settingService->method('findOneBy')->willReturn($setting);

        $request
            ->method('getAttribute')
            ->with('identifier')
            ->willReturn(SettingEnum::IdentifierTableAdminListSelectedColumns->value);

        $handler = new GetSettingViewHandler(
            $authenticationService,
            $adminService,
            $settingService,
        );

        $response = $handler->handle($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertIsArray($data);
        $this->assertIsArray($data['data']);
        $this->assertNotEmpty($data);
        $this->assertNotEmpty($data['data']);
        $this->assertNotEmpty($data['data']['identifier']);
        $this->assertNotEmpty($data['data']['value']);
        $this->assertSame('test', $data['data']['identifier']);
        $this->assertSame('test', $data['data']['value']);
    }
}
