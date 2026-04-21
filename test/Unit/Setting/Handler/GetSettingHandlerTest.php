<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Handler;

use Admin\Admin\Service\AdminService;
use Admin\Admin\Service\AdminServiceInterface;
use Admin\App\Exception\NotFoundException;
use Admin\Setting\Handler\GetViewSettingHandler;
use Admin\Setting\Service\SettingService;
use Admin\Setting\Service\SettingServiceInterface;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminIdentity;
use Core\Admin\Repository\AdminRepository;
use Core\App\Message;
use Core\Setting\Entity\Setting;
use Core\Setting\Enum\SettingIdentifierEnum;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;

use function json_decode;

class GetSettingHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $handler = new GetViewSettingHandler(
            $this->createStub(AuthenticationServiceInterface::class),
            $this->createStub(AdminService::class),
            $this->createStub(SettingService::class),
        );

        $this->assertSame(GetViewSettingHandler::class, $handler::class);
    }

    /**
     * @throws Exception
     */
    public function testInvalidIdentifierProvided(): void
    {
        $authenticationService = $this->createStub(AuthenticationServiceInterface::class);
        $adminService          = $this->createStub(AdminService::class);
        $settingService        = $this->createStub(SettingService::class);
        $request               = $this->createStub(ServerRequestInterface::class);

        $handler = new GetViewSettingHandler(
            $authenticationService,
            $adminService,
            $settingService,
        );

        $request->method('getAttribute')->willReturn('test');

        $response = $handler->handle($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
        $this->assertIsArray($data);
        $this->assertCount(1, $data['error']['messages']);
        $this->assertSame(Message::settingNotFound('test'), $data['error']['messages'][0]);
    }

    /**
     * @throws Exception
     */
    public function testInvalidAdminProvided(): void
    {
        $authenticationService = $this->createStub(AuthenticationServiceInterface::class);
        $adminService          = $this->createStub(AdminServiceInterface::class);
        $settingService        = $this->createStub(SettingServiceInterface::class);
        $request               = $this->createStub(ServerRequestInterface::class);
        $identity              = $this->createStub(AdminIdentity::class);

        $identity->method('getId')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $adminService->method('findAdmin')->willThrowException(new NotFoundException(Message::ADMIN_NOT_FOUND));

        $request
            ->method('getAttribute')
            ->willReturn(SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns->value);

        $handler = new GetViewSettingHandler(
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
        $authenticationService = $this->createStub(AuthenticationServiceInterface::class);
        $adminService          = $this->createStub(AdminServiceInterface::class);
        $settingService        = $this->createStub(SettingServiceInterface::class);
        $request               = $this->createStub(ServerRequestInterface::class);
        $identity              = $this->createStub(AdminIdentity::class);
        $admin                 = $this->createStub(Admin::class);

        $identity->method('getId')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $adminService->method('findAdmin')->willReturn($admin);

        $request
            ->method('getAttribute')
            ->willReturn(SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns->value);

        $handler = new GetViewSettingHandler(
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
            Message::settingNotFound(SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns->value),
            $data['error']['messages'][0]
        );
    }

    /**
     * @throws Exception
     */
    public function testValidDataProvided(): void
    {
        $authenticationService = $this->createStub(AuthenticationServiceInterface::class);
        $adminService          = $this->createStub(AdminService::class);
        $settingService        = $this->createStub(SettingService::class);
        $adminRepository       = $this->createStub(AdminRepository::class);
        $request               = $this->createStub(ServerRequestInterface::class);
        $identity              = $this->createStub(AdminIdentity::class);
        $admin                 = $this->createStub(Admin::class);
        $setting               = $this->createStub(Setting::class);

        $identity->method('getId')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $adminRepository->method('findOneBy')->willReturn($admin);
        $adminService->method('getAdminRepository')->willReturn($adminRepository);
        $setting->method('getArrayCopy')->willReturn([
            'identifier' => 'test',
            'value'      => 'test',
        ]);
        $settingService->method('findOneBy')->willReturn($setting);

        $request
            ->method('getAttribute')
            ->willReturn(SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns->value);

        $handler = new GetViewSettingHandler(
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
