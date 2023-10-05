<?php

declare(strict_types=1);

namespace FrontendTest\Unit\App\Common;

use Fig\Http\Message\RequestMethodInterface;
use Frontend\App\Common\ServerRequestAwareInterface;
use Frontend\App\Common\ServerRequestAwareTrait;
use FrontendTest\Unit\UnitTest;
use PHPUnit\Framework\MockObject\Exception;
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
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_DELETE);

        $controller = $this->getController($request);
        $this->assertTrue($controller->isDelete());
    }

    /**
     * @throws Exception
     */
    public function testRequestMethodIsGet(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_GET);

        $controller = $this->getController($request);
        $this->assertTrue($controller->isGet());
    }

    /**
     * @throws Exception
     */
    public function testRequestMethodIsPatch(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_PATCH);

        $controller = $this->getController($request);
        $this->assertTrue($controller->isPatch());
    }

    /**
     * @throws Exception
     */
    public function testRequestMethodIsPost(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_POST);

        $controller = $this->getController($request);
        $this->assertTrue($controller->isPost());
    }

    /**
     * @throws Exception
     */
    public function testRequestMethodIsPut(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn(RequestMethodInterface::METHOD_PUT);

        $controller = $this->getController($request);
        $this->assertTrue($controller->isPut());
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

        $controller = $this->getController($request);
        $this->assertIsArray($controller->getPostParams());
        $this->assertIsArray($controller->getPostParams('strtoupper'));
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

        $this->assertIsObject($this->getController($request)->getPostParams());
    }

    /**
     * @throws Exception
     */
    public function testWillReturnPostParamsWhenParsedBodyIsNull(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getParsedBody')->willReturn(null);

        $this->assertNull($this->getController($request)->getPostParams());
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

        $this->assertNull($this->getController($request)->getPostParam('invalid'));
        $this->assertSame('test', $this->getController($request)->getPostParam('invalid', 'test'));
        $this->assertSame(1, $this->getController($request)->getPostParam('invalid', '1', 'int'));

        $this->assertSame('1', $this->getController($request)->getPostParam('id'));
        $this->assertSame('1', $this->getController($request)->getPostParam('id', '2'));
        $this->assertSame(1, $this->getController($request)->getPostParam('id', '2', 'int'));
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

        $this->assertIsArray($this->getController($request)->getUploadedFiles());
        $this->assertIsArray(
            $this->getController($request)
                ->getUploadedFiles(
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
            $this->getController($request)->getUploadedFile('valid')
        );

        $this->assertIsObject(
            $this->getController($request)->getUploadedFile('valid', function (UploadedFileInterface $uploadedFile) {
                return $uploadedFile;
            })
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('There is no file uploaded under the name: invalid');
        $this->getController($request)->getUploadedFile('invalid');
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

        $this->assertIsArray($this->getController($request)->getQueryParams());
        $this->assertSame($default, $this->getController($request)->getQueryParams());
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getController($request)->getQueryParams('strtoupper')
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

        $this->assertNull($this->getController($request)->getQueryParam('invalid'));
        $this->assertSame('test', $this->getController($request)->getQueryParam('invalid', 'test'));
        $this->assertSame(1, $this->getController($request)->getQueryParam('invalid', '1', 'int'));

        $this->assertSame('1', $this->getController($request)->getQueryParam('id'));
        $this->assertSame('1', $this->getController($request)->getQueryParam('id', '2'));
        $this->assertSame(1, $this->getController($request)->getQueryParam('id', '2', 'int'));
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

        $this->assertIsArray($this->getController($request)->getCookieParams());
        $this->assertSame($default, $this->getController($request)->getCookieParams());
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getController($request)->getCookieParams('strtoupper')
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

        $this->assertNull($this->getController($request)->getCookieParam('invalid'));
        $this->assertSame('test', $this->getController($request)->getCookieParam('invalid', 'test'));
        $this->assertSame(1, $this->getController($request)->getCookieParam('invalid', '1', 'int'));

        $this->assertSame('1', $this->getController($request)->getCookieParam('id'));
        $this->assertSame('1', $this->getController($request)->getCookieParam('id', '2'));
        $this->assertSame(1, $this->getController($request)->getCookieParam('id', '2', 'int'));
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

        $this->assertIsArray($this->getController($request)->getServerParams());
        $this->assertSame($default, $this->getController($request)->getServerParams());
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getController($request)->getServerParams('strtoupper')
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

        $this->assertNull($this->getController($request)->getServerParam('invalid'));
        $this->assertSame('test', $this->getController($request)->getServerParam('invalid', 'test'));
        $this->assertSame(1, $this->getController($request)->getServerParam('invalid', '1', 'int'));

        $this->assertSame('1', $this->getController($request)->getServerParam('id'));
        $this->assertSame('1', $this->getController($request)->getServerParam('id', '2'));
        $this->assertSame(1, $this->getController($request)->getServerParam('id', '2', 'int'));
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

        $this->assertIsArray($this->getController($request)->getHeaders());
        $this->assertSame($default, $this->getController($request)->getHeaders());
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getController($request)->getHeaders('strtoupper')
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

        $this->assertNull($this->getController($request)->getHeader('invalid'));
        $this->assertSame('test', $this->getController($request)->getHeader('invalid', 'test'));
        $this->assertSame(1, $this->getController($request)->getHeader('invalid', '1', 'int'));

        $this->assertSame('1', $this->getController($request)->getHeader('id'));
        $this->assertSame('1', $this->getController($request)->getHeader('id', '2'));
        $this->assertSame(1, $this->getController($request)->getHeader('id', '2', 'int'));
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

        $this->assertIsArray($this->getController($request)->getAttributes());
        $this->assertSame($default, $this->getController($request)->getAttributes());
        $this->assertSame(
            array_map('strtoupper', $default),
            $this->getController($request)->getAttributes('strtoupper')
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

        $this->assertNull($this->getController($request)->getAttribute('invalid'));
        $this->assertSame('test', $this->getController($request)->getAttribute('invalid', 'test'));
        $this->assertSame(1, $this->getController($request)->getAttribute('invalid', '1', 'int'));

        $this->assertSame('1', $this->getController($request)->getAttribute('id'));
        $this->assertSame('1', $this->getController($request)->getAttribute('id', '2'));
        $this->assertSame(1, $this->getController($request)->getAttribute('id', '2', 'int'));
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testWillCast(): void
    {
        $request    = $this->createMock(ServerRequestInterface::class);
        $controller = $this->getController($request);

        $reflection = new ReflectionClass($controller);

        $method = $reflection->getMethod('cast');
        $this->assertSame(['test'], $method->invoke($controller, 'test', 'array'));
        $this->assertTrue($method->invoke($controller, 'test', 'bool'));
        $this->assertSame(3.14, $method->invoke($controller, '3.14', 'float'));
        $this->assertSame(256, $method->invoke($controller, '256', 'int'));
        $this->assertIsObject($method->invoke($controller, 'test', 'object'));
        $this->assertSame('test', $method->invoke($controller, 'test', 'string'));
        $this->assertSame('test', $method->invoke($controller, 'test', 'invalid'));
        $this->assertSame('test', $method->invoke($controller, 'test'));
    }

    private function getController(ServerRequestInterface $request): ServerRequestAwareInterface
    {
        return new class ($request) implements ServerRequestAwareInterface {
            use ServerRequestAwareTrait;

            protected ServerRequestInterface $request;

            public function __construct(ServerRequestInterface $request)
            {
                $this->request = $request;
            }
        };
    }
}
