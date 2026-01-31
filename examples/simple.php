<?php

/*
 * Run with `php simple.php`. Don't forget to set the SUMUP_API_KEY and
 * SUMUP_MERCHANT_CODE environment variables before running the script.
 */

require __DIR__ . '/../vendor/autoload.php';

$apiKey = getenv('SUMUP_API_KEY');
$merchantCode = getenv('SUMUP_MERCHANT_CODE');

if (!$apiKey) {
    fwrite(STDERR, "Missing SUMUP_API_KEY environment variable\n");
    exit(1);
}

if (!$merchantCode) {
    fwrite(STDERR, "Missing SUMUP_MERCHANT_CODE environment variable\n");
    exit(1);
}

// Option 1: Create SDK with API key
$sumup = new \SumUp\SumUp($apiKey);

// Option 2: Create SDK with access token
// $sumup = new \SumUp\SumUp([
//     'access_token' => 'your-access-token-here',
// ]);

// Option 3: Create SDK without token, set later
// $sumup = new \SumUp\SumUp();
// $sumup->setDefaultAccessToken('your-token-here');

// Use services with the default token
$merchant = $sumup->merchants->get($merchantCode);
print_r($merchant);

// Override the default token by creating a new client instance instead.
