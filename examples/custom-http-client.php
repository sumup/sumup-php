<?php

/*
 * Example demonstrating how to use a custom HTTP client with the SumUp SDK.
 *
 * Run with `php custom-http-client.php`. Don't forget to set the SUMUP_API_KEY
 * environment variable before running the script.
 */

require __DIR__ . '/../vendor/autoload.php';

$apiKey = getenv('SUMUP_API_KEY');

if (!$apiKey) {
    fwrite(STDERR, "Missing SUMUP_API_KEY environment variable\n");
    exit(1);
}

/**
 * Example custom HTTP client implementation.
 * 
 * This demonstrates how to create your own HTTP client by implementing
 * the SumUpHttpClientInterface. You could use this to:
 * - Add custom logging
 * - Implement retry logic
 * - Use a different HTTP library
 * - Add custom middleware
 */
class CustomLoggingHttpClient implements \SumUp\HttpClients\SumUpHttpClientInterface
{
    private $wrappedClient;

    public function __construct(\SumUp\HttpClients\SumUpHttpClientInterface $wrappedClient)
    {
        $this->wrappedClient = $wrappedClient;
    }

    public function send($method, $url, $body, $headers)
    {
        // Log the request
        echo "[HTTP Request] {$method} {$url}\n";
        if (!empty($body)) {
            echo "[HTTP Body] " . json_encode($body) . "\n";
        }

        // Forward to the wrapped client
        $response = $this->wrappedClient->send($method, $url, $body, $headers);

        // Log the response
        echo "[HTTP Response] Status: " . $response->getHttpStatusCode() . "\n";

        return $response;
    }
}

// First, create a base HTTP client (cURL by default)
$baseUrl = 'https://api.sumup.com';
$customHeaders = ['User-Agent' => 'SumUp-PHP-SDK-Custom'];
$caBundlePath = null;

// Create base cURL client
$baseClient = new \SumUp\HttpClients\SumUpCUrlClient(
    $baseUrl,
    $customHeaders,
    $caBundlePath
);

// Wrap it with our custom logging client
$customClient = new CustomLoggingHttpClient($baseClient);

// Pass the custom client to the SumUp SDK
$sumup = new \SumUp\SumUp(
    ['api_key' => $apiKey],
    $customClient
);

// Use the SDK normally - all requests will be logged
try {
    $merchant = $sumup->merchant->get();
    echo "\nMerchant retrieved successfully!\n";
    echo "Merchant code: " . $merchant->merchant_code . "\n";
} catch (\SumUp\Exceptions\SumUpSDKException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
