<?php

declare(strict_types=1);

namespace AdminTest\Unit\App\Common;

use Admin\App\Common\ServerRequestAwareInterface;
use Admin\App\Common\ServerRequestAwareTrait;
use AdminTest\Unit\UnitTest;
use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use ReflectionClass;
use ReflectionException;
use stdClass;

use function array_map;

class ServerRequestAwareTest extends UnitTest
{
    /**
     * @throws Exception
     */
    public function testRequestMethodIsDelete(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->expects($this->once())->method('getMethod')
            ->willReturn(RequestMethodInterface::METHOD_DELETE);

        $handler = $this->getHandler($request);
        $this->assertTrue($handler->isDelete($request));
    }

    /**
     * @throws Exception
     */
    public function testRequestMethodIsGet(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_GET);

        $handler = $this->getHandler($request);
        $this->assertTrue($handler->isGet($request));
    }

    /**
     * @throws Exception
     */
    public function testRequestMethodIsPatch(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_PATCH);

        $handler = $this->getHandler($request);
        $this->assertTrue($handler->isPatch($request));
    }

    /**
     * @throws Exception
     */
    public function testRequestMethodIsPost(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_POST);

        $handler = $this->getHandler($request);
        $this->assertTrue($handler->isPost($request));
    }

    /**
     * @throws Exception
     */
    public function testRequestMethodIsPut(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_PUT);

        $handler = $this->getHandler($request);
        $this->assertTrue($handler->isPut($request));
    }

    /**
     * @throws Exception
     */
    public function testWillReturnPostParamsWhenParsedBodyIsArray(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->exactly(2))->method('getParsedBody')->willReturn([
            'test',
        ]);

        $handler = $this->getHandler($request);
        $this->assertIsArray($handler->getPostParams($request));
        $this->assertIsArray($handler->getPostParams($request, 'strtoupper'));
    }

    /**
     * @throws Exception
     */
    public function testWillReturnPostParamsWhenParsedBodyIsObject(): void
    {
        $object       = new stdClass();
        $object->test = 'test';

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getParsedBody')->willReturn($object);

        $this->assertIsObject($this->getHandler($request)->getPostParams($request));
    }

    /**
     * @throws Exception
     */
    public function testWillReturnPostParamsWhenParsedBodyIsNull(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getParsedBody')->willReturn(null);

        $this->assertNull($this->getHandler($request)->getPostParams($request));
    }

    /**
     * @throws Exception
     */
    public function testWillGetPostParam(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getParsedBody')->willReturn([
            'id' => '1',
        ]);

        $this->assertNull($this->getHandler($request)->getPostParam($request, 'invalid'));
        $this->assertSame('test', $this->getHandler($request)->getPostParam($request, 'invalid', 'test'));
        $this->assertSame(1, $this->getHandler($request)->getPostParam($request, 'invalid', '1', 'int'));

        $this->assertSame('1', $this->getHandler($request)->getPostParam($request, 'id'));
        $this->assertSame('1', $this->getHandler($request)->getPostParam($request, 'id', '2'));
        $this->assertSame(1, $this->getHandler($request)->getPostParam($request, 'id', '2', 'int'));
    }

    /**
     * @throws Exception
     */
    public function testWillGetUploadedFiles(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getUploadedFiles')->willReturn([
            $this->createMock(UploadedFileInterface::class),
        ]);

        $this->assertIsArray($this->getHandler($request)->getUploadedFiles($request));
        $this->assertIsArray(
            $this->getHandler($request)
                ->getUploadedFiles(
                    $request,
                    function (UploadedFileInterface $uploadedFile) {
                        return $uploadedFile;
                    }
                )
        );
    }

    /**
     * @throws Exception
     */
    public function testWillGetUploadedFile(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getUploadedFiles')->willReturn([
            'valid' => $this->createMock(UploadedFileInterface::class),
        ]);

        $this->assertInstanceOf(
            UploadedFileInterface::class,
            $this->getHandler($request)->getUploadedFile($request, 'valid')
        );

        $this->assertIsObject(
            $this->getHandler($request)->getUploadedFile(
                $request,
                'valid',
                function (UploadedFileInterface $uploadedFile) {
                    return $uploadedFile;
                }
            )
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('There is no file uploaded under the name: invalid');
        $this->getHandler($request)->getUploadedFile($request, 'invalid');
    }

    /**
     * @throws Exception
     */
    public function testWillGetQueryParams(): void
    {
        $default = [
            'key' => 'value',
        ];

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getQueryParams')->willReturn($default);

        $this->assertIsArray($this->getHandler($request)->getQueryParams($request));
        $this->assertSame($default, $this->getHandler($request)->getQueryParams($request));
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getHandler($request)->getQueryParams($request, 'strtoupper')
        );
    }

    /**
     * @throws Exception
     */
    public function testWillGetQueryParam(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getQueryParams')->willReturn([
            'id' => '1',
        ]);

        $this->assertNull($this->getHandler($request)->getQueryParam($request, 'invalid'));
        $this->assertSame('test', $this->getHandler($request)->getQueryParam($request, 'invalid', 'test'));
        $this->assertSame(1, $this->getHandler($request)->getQueryParam($request, 'invalid', '1', 'int'));

        $this->assertSame('1', $this->getHandler($request)->getQueryParam($request, 'id'));
        $this->assertSame('1', $this->getHandler($request)->getQueryParam($request, 'id', '2'));
        $this->assertSame(1, $this->getHandler($request)->getQueryParam($request, 'id', '2', 'int'));
    }

    /**
     * @throws Exception
     */
    public function testWillGetCookieParams(): void
    {
        $default = [
            'key' => 'value',
        ];

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getCookieParams')->willReturn($default);

        $this->assertIsArray($this->getHandler($request)->getCookieParams($request));
        $this->assertSame($default, $this->getHandler($request)->getCookieParams($request));
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getHandler($request)->getCookieParams($request, 'strtoupper')
        );
    }

    /**
     * @throws Exception
     */
    public function testWillGetCookieParam(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getCookieParams')->willReturn([
            'id' => '1',
        ]);

        $this->assertNull($this->getHandler($request)->getCookieParam($request, 'invalid'));
        $this->assertSame('test', $this->getHandler($request)->getCookieParam($request, 'invalid', 'test'));
        $this->assertSame(1, $this->getHandler($request)->getCookieParam($request, 'invalid', '1', 'int'));

        $this->assertSame('1', $this->getHandler($request)->getCookieParam($request, 'id'));
        $this->assertSame('1', $this->getHandler($request)->getCookieParam($request, 'id', '2'));
        $this->assertSame(1, $this->getHandler($request)->getCookieParam($request, 'id', '2', 'int'));
    }

    /**
     * @throws Exception
     */
    public function testWillGetServerParams(): void
    {
        $default = [
            'key' => 'value',
        ];

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getServerParams')->willReturn($default);

        $this->assertIsArray($this->getHandler($request)->getServerParams($request));
        $this->assertSame($default, $this->getHandler($request)->getServerParams($request));
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getHandler($request)->getServerParams($request, 'strtoupper')
        );
    }

    /**
     * @throws Exception
     */
    public function testWillGetServerParam(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getServerParams')->willReturn([
            'id' => '1',
        ]);

        $this->assertNull($this->getHandler($request)->getServerParam($request, 'invalid'));
        $this->assertSame('test', $this->getHandler($request)->getServerParam($request, 'invalid', 'test'));
        $this->assertSame(1, $this->getHandler($request)->getServerParam($request, 'invalid', '1', 'int'));

        $this->assertSame('1', $this->getHandler($request)->getServerParam($request, 'id'));
        $this->assertSame('1', $this->getHandler($request)->getServerParam($request, 'id', '2'));
        $this->assertSame(1, $this->getHandler($request)->getServerParam($request, 'id', '2', 'int'));
    }

    /**
     * @throws Exception
     */
    public function testWillGetHeaders(): void
    {
        $default = [
            'key' => 'value',
        ];

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getHeaders')->willReturn($default);

        $this->assertIsArray($this->getHandler($request)->getHeaders($request));
        $this->assertSame($default, $this->getHandler($request)->getHeaders($request));
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getHandler($request)->getHeaders($request, 'strtoupper')
        );
    }

    /**
     * @throws Exception
     */
    public function testWillGetHeader(): void
    {
        $default = [
            'id' => '1',
        ];

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getHeaders')->willReturn($default);
        $request->expects($this->any())->method('getHeaderLine')->with('id')->willReturn($default['id']);

        $this->assertNull($this->getHandler($request)->getHeader($request, 'invalid'));
        $this->assertSame('test', $this->getHandler($request)->getHeader($request, 'invalid', 'test'));
        $this->assertSame(1, $this->getHandler($request)->getHeader($request, 'invalid', '1', 'int'));

        $this->assertSame('1', $this->getHandler($request)->getHeader($request, 'id'));
        $this->assertSame('1', $this->getHandler($request)->getHeader($request, 'id', '2'));
        $this->assertSame(1, $this->getHandler($request)->getHeader($request, 'id', '2', 'int'));
    }

    /**
     * @throws Exception
     */
    public function testWillGetAttributes(): void
    {
        $default = [
            'key' => 'value',
        ];

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getAttributes')->willReturn($default);

        $this->assertIsArray($this->getHandler($request)->getAttributes($request));
        $this->assertSame($default, $this->getHandler($request)->getAttributes($request));
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getHandler($request)->getAttributes($request, 'strtoupper')
        );
    }

    /**
     * @throws Exception
     */
    public function testWillGetAttribute(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->any())->method('getAttributes')->willReturn([
            'id' => '1',
        ]);

        $this->assertNull($this->getHandler($request)->getAttribute($request, 'invalid'));
        $this->assertSame('test', $this->getHandler($request)->getAttribute($request, 'invalid', 'test'));
        $this->assertSame(1, $this->getHandler($request)->getAttribute($request, 'invalid', '1', 'int'));

        $this->assertSame('1', $this->getHandler($request)->getAttribute($request, 'id'));
        $this->assertSame('1', $this->getHandler($request)->getAttribute($request, 'id', '2'));
        $this->assertSame(1, $this->getHandler($request)->getAttribute($request, 'id', '2', 'int'));
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testWillCast(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $handler = $this->getHandler($request);

        $reflection = new ReflectionClass($handler);

        $method = $reflection->getMethod('cast');
        $this->assertSame(['test'], $method->invoke($handler, 'test', 'array'));
        $this->assertTrue($method->invoke($handler, 'test', 'bool'));
        $this->assertSame(3.14, $method->invoke($handler, '3.14', 'float'));
        $this->assertSame(256, $method->invoke($handler, '256', 'int'));
        $this->assertIsObject($method->invoke($handler, 'test', 'object'));
        $this->assertSame('test', $method->invoke($handler, 'test', 'string'));
        $this->assertSame('test', $method->invoke($handler, 'test', 'invalid'));
        $this->assertSame('test', $method->invoke($handler, 'test'));
    }

    private function getHandler(ServerRequestInterface $request): ServerRequestAwareInterface
    {
        return new class ($request) implements ServerRequestAwareInterface {
            use ServerRequestAwareTrait;

            protected ServerRequestInterface $request;

            public function __construct(ServerRequestInterface $request)
            {
                $this->request = $request;
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return new EmptyResponse(StatusCodeInterface::STATUS_OK);
            }
        };
    }
}
