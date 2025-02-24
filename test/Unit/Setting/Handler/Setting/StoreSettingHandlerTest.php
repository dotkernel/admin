<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Handler\Setting;

use Admin\Admin\Entity\Admin;
use Admin\Admin\Entity\AdminIdentity;
use Admin\Admin\Repository\AdminRepository;
use Admin\Admin\Service\AdminService;
use Admin\App\Message;
use Admin\Setting\Entity\Setting;
use Admin\Setting\Handler\Setting\StoreSettingHandler;
use Admin\Setting\Service\SettingService;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

use function json_decode;
use function json_encode;
use function sprintf;

class StoreSettingHandlerTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testWillCreate(): void
    {
        $handler = new StoreSettingHandler(
            $this->createMock(AuthenticationServiceInterface::class),
            $this->createMock(AdminService::class),
            $this->createMock(SettingService::class),
        );

        $this->assertInstanceOf(StoreSettingHandler::class, $handler);
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
        $stream                = $this->createMock(StreamInterface::class);

        $handler = new StoreSettingHandler(
            $authenticationService,
            $adminService,
            $settingService,
        );

        $stream->method('getContents')->willReturn(json_encode([
            'identifier' => 'test',
            'value'      => 'test',
        ]));

        $request->method('getAttribute')->with('identifier')->willReturn('test');
        $request->method('getBody')->willReturn($stream);

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
        $stream                = $this->createMock(StreamInterface::class);

        $identity->method('getUuid')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $adminRepository->method('findOneBy')->with(['uuid' => 'test'])->willReturn(null);
        $adminService->method('getAdminRepository')->willReturn($adminRepository);
        $stream->method('getContents')->willReturn(json_encode([
            'identifier' => 'test',
            'value'      => 'test',
        ]));

        $request
            ->method('getAttribute')
            ->with('identifier')
            ->willReturn(Setting::IDENTIFIER_TABLE_ADMIN_LIST_SELECTED_COLUMNS);

        $request->method('getAttribute')->with('identifier')->willReturn('test');
        $request->method('getBody')->willReturn($stream);

        $handler = new StoreSettingHandler(
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
    public function testUpdateSetting(): void
    {
        $authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $adminService          = $this->createMock(AdminService::class);
        $settingService        = $this->createMock(SettingService::class);
        $adminRepository       = $this->createMock(AdminRepository::class);
        $request               = $this->createMock(ServerRequestInterface::class);
        $identity              = $this->createMock(AdminIdentity::class);
        $admin                 = $this->createMock(Admin::class);
        $stream                = $this->createMock(StreamInterface::class);
        $setting               = $this->createMock(Setting::class);

        $identity->method('getUuid')->willReturn('test');
        $authenticationService->method('getIdentity')->willReturn($identity);
        $settingService->method('findOneBy')->willReturn($setting);
        $settingService->expects($this->once())->method('updateSetting');
        $adminRepository->method('findOneBy')->with(['uuid' => 'test'])->willReturn($admin);
        $adminService->method('getAdminRepository')->willReturn($adminRepository);
        $stream->method('getContents')->willReturn(json_encode([
            'identifier' => Setting::IDENTIFIER_TABLE_ADMIN_LIST_SELECTED_COLUMNS,
            'value'      => ['test'],
        ]));

        $request->method('getBody')->willReturn($stream);
        $request
            ->method('getAttribute')
            ->with('identifier')
            ->willReturn(Setting::IDENTIFIER_TABLE_ADMIN_LIST_SELECTED_COLUMNS);

        $handler = new StoreSettingHandler(
            $authenticationService,
            $adminService,
            $settingService,
        );

        $response = $handler->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
