<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Exception\ApiException;
use SumUp\Exception\UnexpectedApiException;
use SumUp\HttpClient\Response;
use SumUp\ResponseDecoder;
use SumUp\Types\Error;

class ResponseDecoderTest extends TestCase
{
    public function testDecodeOrThrowUsesExpectedApiExceptionForKnownErrorDescriptor()
    {
        $response = new Response(401, [
            'error_code' => 'NOT_AUTHORIZED',
            'message' => 'Token expired',
        ]);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Token expired');

        ResponseDecoder::decodeOrThrow(
            $response,
            null,
            [
                '401' => ['type' => 'class', 'class' => Error::class],
            ],
            'GET',
            '/v0.1/me'
        );
    }

    public function testDecodeOrThrowUsesUnexpectedApiExceptionForUnknownErrorFormat()
    {
        $response = new Response(400, [
            ['error_code' => 'MISSING', 'param' => 'merchant_code'],
            ['error_code' => 'INVALID', 'param' => 'currency'],
        ]);

        try {
            ResponseDecoder::decodeOrThrow($response, null, null, 'POST', '/v0.1/checkouts');
            $this->fail('UnexpectedApiException was not thrown');
        } catch (UnexpectedApiException $exception) {
            $this->assertSame('POST', $exception->getHttpMethod());
            $this->assertSame('/v0.1/checkouts', $exception->getPath());
            $this->assertSame(400, $exception->getStatusCode());
            $this->assertSame($response->getBody(), $exception->getResponseBody());
            $this->assertSame('Unexpected API response (400)', $exception->getMessage());
        }
    }

    public function testDecodeOrThrowUsesKnownErrorDescriptorFromOpenApi()
    {
        $response = new Response(404, [
            'message' => 'Checkout not found',
            'error_code' => 'NOT_FOUND',
        ]);

        try {
            ResponseDecoder::decodeOrThrow(
                $response,
                null,
                [
                    '404' => ['type' => 'class', 'class' => Error::class],
                ],
                'GET',
                '/v0.1/checkouts/chk_123'
            );
            $this->fail('ApiException was not thrown');
        } catch (ApiException $exception) {
            $this->assertSame('GET', $exception->getHttpMethod());
            $this->assertSame('/v0.1/checkouts/chk_123', $exception->getPath());
            $this->assertInstanceOf(Error::class, $exception->getResponseBody());
            $this->assertSame('Checkout not found', $exception->getMessage());
        }
    }

    public function testDecodeOrThrowReturnsUnexpectedApiExceptionForUnknownErrorFormat()
    {
        $response = new Response(502, '<html>bad gateway</html>');

        try {
            ResponseDecoder::decodeOrThrow($response, null, null, 'GET', '/v0.1/checkouts');
            $this->fail('UnexpectedApiException was not thrown');
        } catch (UnexpectedApiException $exception) {
            $this->assertSame('GET', $exception->getHttpMethod());
            $this->assertSame('/v0.1/checkouts', $exception->getPath());
            $this->assertSame(502, $exception->getStatusCode());
            $this->assertSame('<html>bad gateway</html>', $exception->getResponseBody());
            $this->assertSame('Unexpected API response (502)', $exception->getMessage());
        }
    }
}
