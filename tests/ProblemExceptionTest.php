<?php

use PHPUnit\Framework\TestCase;
use SumUp\Exception\ApiException;
use SumUp\Exception\UnexpectedApiException;
use SumUp\HttpClient\Response;
use SumUp\ResponseDecoder;
use SumUp\Types\Problem;

final class ProblemExceptionTest extends TestCase
{
    public function testProblemAndOriginalResponseRemainAvailable(): void
    {
        $body = ['type' => 'about:blank', 'detail' => 'Invalid amount'];
        $response = new Response(400, $body, ['Retry-After' => ['10']], json_encode($body));
        try {
            ResponseDecoder::decodeOrThrow($response, null, ['400' => ['type' => 'class', 'class' => Problem::class]]);
            self::fail('Expected API error');
        } catch (ApiException $error) {
            self::assertInstanceOf(Problem::class, $error->getProblem());
            self::assertSame($error->getResponseBody(), $error->getProblem());
            self::assertSame('Invalid amount', $error->getProblem()->detail);
            self::assertSame($response, $error->getResponse());
        }
    }

    public function testInvalidProblemRemainsAnApiError(): void
    {
        $body = ['type' => null];
        $response = new Response(400, $body);
        try {
            ResponseDecoder::decodeOrThrow($response, null, ['400' => ['type' => 'class', 'class' => Problem::class]]);
            self::fail('Expected API error');
        } catch (ApiException $error) {
            self::assertNull($error->getProblem());
            self::assertSame($body, $error->getResponseBody());
        }
    }

    public function testUnexpectedResponsesKeepTheirOriginalBody(): void
    {
        $response = new Response(502, 'Bad gateway', [], 'Bad gateway');
        try {
            ResponseDecoder::decodeOrThrow($response);
            self::fail('Expected API error');
        } catch (UnexpectedApiException $error) {
            self::assertNull($error->getProblem());
            self::assertSame($response, $error->getResponse());
            self::assertSame('Bad gateway', $error->getResponse()->getRawBody());
        }
    }
}
