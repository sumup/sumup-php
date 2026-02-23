<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Exception\ApiException;
use SumUp\Exception\AuthenticationException;
use SumUp\Exception\ValidationException;
use SumUp\HttpClient\Response;
use SumUp\ResponseDecoder;
use SumUp\Types\Error;

class ResponseDecoderTest extends TestCase
{
    public function testDecodeOrThrowMapsAuthenticationErrorFromAssociativeArray()
    {
        $response = new Response(401, [
            'error_code' => 'NOT_AUTHORIZED',
            'error_message' => 'Token expired',
        ]);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Token expired');

        ResponseDecoder::decodeOrThrow($response, null, null, 'GET', '/v0.1/me');
    }

    public function testDecodeOrThrowMapsValidationErrorsFromAssociativeArrayList()
    {
        $response = new Response(400, [
            ['error_code' => 'MISSING', 'param' => 'merchant_code'],
            ['error_code' => 'INVALID', 'param' => 'currency'],
        ]);

        try {
            ResponseDecoder::decodeOrThrow($response, null, null, 'POST', '/v0.1/checkouts');
            $this->fail('ValidationException was not thrown');
        } catch (ValidationException $exception) {
            $this->assertSame(['merchant_code', 'currency'], $exception->getInvalidFields());
            $this->assertSame(400, $exception->getStatusCode());
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
            $this->assertTrue($exception->hasKnownFormat());
            $this->assertSame('GET', $exception->getHttpMethod());
            $this->assertSame('/v0.1/checkouts/chk_123', $exception->getPath());
            $this->assertInstanceOf(Error::class, $exception->getResponseBody());
            $this->assertSame('Checkout not found', $exception->getMessage());
        }
    }

    public function testDecodeOrThrowReturnsGenericApiExceptionForUnknownErrorFormat()
    {
        $response = new Response(502, '<html>bad gateway</html>');

        try {
            ResponseDecoder::decodeOrThrow($response, null, null, 'GET', '/v0.1/checkouts');
            $this->fail('ApiException was not thrown');
        } catch (ApiException $exception) {
            $this->assertFalse($exception->hasKnownFormat());
            $this->assertSame('GET', $exception->getHttpMethod());
            $this->assertSame('/v0.1/checkouts', $exception->getPath());
            $this->assertSame(502, $exception->getStatusCode());
            $this->assertSame('<html>bad gateway</html>', $exception->getResponseBody());
            $this->assertSame('Server error', $exception->getMessage());
        }
    }
}
