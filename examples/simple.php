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

$sumup = new \SumUp\SumUp([
    'api_key' => $apiKey,
]);

$merchant = $sumup->merchants->get($merchantCode);
print_r($merchant);

print_r($merchant->merchantCode);
