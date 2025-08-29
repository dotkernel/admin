<?php

declare(strict_types=1);

namespace AdminTest\Unit\Setting\Handler;

use Admin\Admin\Service\AdminService;
use Admin\App\Exception\NotFoundException;
use Admin\Setting\Handler\PostStoreSettingHandler;
use Admin\Setting\Service\SettingService;
use AdminTest\Unit\UnitTest;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminIdentity;
use Core\App\Message;
use Core\Setting\Entity\Setting;
use Core\Setting\Enum\SettingIdentifierEnum;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

use function json_decode;
use function json_encode;
use function sprintf;

class StoreSettingHandlerTest extends UnitTest
{
    private MockObject&AuthenticationServiceInterface $authenticationService;
    private MockObject&AdminService $adminService;
    private MockObject&SettingService $settingService;
    private MockObject&ServerRequestInterface $request;
    private MockObject&StreamInterface $stream;
    private MockObject&AdminIdentity $identity;
    private MockObject&Admin $admin;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $this->adminService          = $this->createMock(AdminService::class);
        $this->settingService        = $this->createMock(SettingService::class);
        $this->request               = $this->createMock(ServerRequestInterface::class);
        $this->stream                = $this->createMock(StreamInterface::class);
        $this->identity              = $this->createMock(AdminIdentity::class);
        $this->admin                 = $this->createMock(Admin::class);
    }

    public function testWillCreate(): void
    {
        $handler = new PostStoreSettingHandler(
            $this->authenticationService,
            $this->adminService,
            $this->settingService,
        );

        $this->assertSame(PostStoreSettingHandler::class, $handler::class);
    }

    /**
     * @throws Exception
     */
    public function testInvalidIdentifierProvided(): void
    {
        $handler = new PostStoreSettingHandler(
            $this->authenticationService,
            $this->adminService,
            $this->settingService,
        );

        $this->stream->method('getContents')->willReturn(json_encode([
            'identifier' => 'test',
            'value'      => 'test',
        ]));

        $this->request->method('getAttribute')->with('identifier')->willReturn('test');
        $this->request->method('getBody')->willReturn($this->stream);

        $response = $handler->handle($this->request);

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
        $this->identity->method('getUuid')->willReturn('test');
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->adminService->method('findAdmin')->willThrowException(new NotFoundException(Message::ADMIN_NOT_FOUND));
        $this->stream->method('getContents')->willReturn(json_encode([
            'identifier' => 'test',
            'value'      => 'test',
        ]));

        $this->request
            ->method('getAttribute')
            ->with('identifier')
            ->willReturn(SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns->value);

        $this->request->method('getAttribute')->with('identifier')->willReturn('test');
        $this->request->method('getBody')->willReturn($this->stream);

        $handler = new PostStoreSettingHandler(
            $this->authenticationService,
            $this->adminService,
            $this->settingService,
        );

        $response = $handler->handle($this->request);

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
        $this->identity->method('getUuid')->willReturn('test');
        $this->authenticationService->method('getIdentity')->willReturn($this->identity);
        $this->settingService->method('findOneBy')->willReturn(
            $this->createMock(Setting::class)
        );
        $this->settingService->expects($this->once())->method('updateSetting');
        $this->adminService->method('findAdmin')->willReturn($this->admin);
        $this->stream->method('getContents')->willReturn(json_encode([
            'identifier' => SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns->value,
            'value'      => ['test'],
        ]));

        $this->request->method('getBody')->willReturn($this->stream);
        $this->request
            ->method('getAttribute')
            ->with('identifier')
            ->willReturn(SettingIdentifierEnum::IdentifierTableAdminListSelectedColumns->value);

        $handler = new PostStoreSettingHandler(
            $this->authenticationService,
            $this->adminService,
            $this->settingService,
        );

        $response = $handler->handle($this->request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
