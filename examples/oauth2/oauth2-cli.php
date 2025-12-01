<?php

/**
 * OAuth 2.0 Authorization Code flow with SumUp - Command Line Example
 *
 * This is a simpler command-line version of the OAuth2 flow that's closer
 * to the Go SDK example structure.
 *
 * To run this example:
 * 1. Set environment variables: CLIENT_ID, CLIENT_SECRET
 * 2. Run: php oauth2-cli.php
 * 3. Follow the instructions to complete the OAuth2 flow
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;

function main(): void
{
    $clientId = getenv('CLIENT_ID');
    $clientSecret = getenv('CLIENT_SECRET');
    $redirectUri = 'urn:ietf:wg:oauth:2.0:oob'; // Out-of-band redirect for CLI apps

    if (!$clientId || !$clientSecret) {
        fwrite(STDERR, "Please set CLIENT_ID and CLIENT_SECRET environment variables\n");
        exit(1);
    }

    // Configure the OAuth2 provider for SumUp
    $provider = new GenericProvider([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
        'redirectUri' => $redirectUri,
        'urlAuthorize' => 'https://api.sumup.com/authorize',
        'urlAccessToken' => 'https://api.sumup.com/token',
        'urlResourceOwnerDetails' => '',
        // Scope is a mechanism in OAuth 2.0 to limit an application's access to a user's account.
        // You should always request the minimal set of scope that you need for your application to
        // work. In this example we use "payments transactions.history" scope.
        'scopes' => 'payments transactions.history user.profile_readonly user.app-settings',
    ]);

    // Generate PKCE challenge and verifier for enhanced security
    $codeVerifier = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');

    // Generate random state for security
    $state = bin2hex(random_bytes(32));

    // Get authorization URL with PKCE parameters
    $authorizationUrl = $provider->getAuthorizationUrl([
        'state' => $state,
        'code_challenge' => $codeChallenge,
        'code_challenge_method' => 'S256',
    ]);

    echo "OAuth 2.0 Authorization Code Flow with SumUp\n";
    echo "==========================================\n\n";
    echo "1. Please visit the following URL to authorize the application:\n\n";
    echo "   " . $authorizationUrl . "\n\n";
    echo "2. After authorization, you will be redirected to a page showing an authorization code.\n";
    echo "3. Copy the authorization code and paste it below.\n\n";

    // Read the authorization code from user input
    echo "Enter the authorization code: ";
    $handle = fopen("php://stdin", "r");
    $code = trim(fgets($handle));
    fclose($handle);

    if (empty($code)) {
        fwrite(STDERR, "No authorization code provided\n");
        exit(1);
    }

    try {
        // Exchange the authorization code for an access token
        /** @var AccessToken $accessToken */
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $code,
            'code_verifier' => $codeVerifier,
        ]);

        echo "\nOAuth2 Success!\n";
        echo "===============\n";
        echo "Access Token: " . substr($accessToken->getToken(), 0, 20) . "...\n";
        echo "Token Type: Bearer\n";
        echo "Expires: " . ($accessToken->getExpires() ? date('Y-m-d H:i:s', $accessToken->getExpires()) : 'Never') . "\n";

        if ($accessToken->getRefreshToken()) {
            echo "Refresh Token: Available\n";
        }

        // Now use the access token with the SumUp SDK
        echo "\nTesting SumUp SDK with the obtained token...\n";

        $sumup = new \SumUp\SumUp([
            'access_token' => $accessToken->getToken(),
        ]);

        // Get merchant information (this requires the user.profile_readonly scope)
        echo "Fetching merchant information...\n";
        try {
            // Note: For CLI apps, we don't get the merchant_code in the redirect,
            // so we'll need to get it from the memberships endpoint first
            $memberships = $sumup->memberships->list();
            
            if (!empty($memberships) && isset($memberships[0]->merchant_code)) {
                $merchantCode = $memberships[0]->merchant_code;
                echo "Default Merchant Code: " . $merchantCode . "\n";

                $merchant = $sumup->merchants->get($merchantCode);
                echo "Merchant Name: " . ($merchant->business_name ?? 'N/A') . "\n";
                echo "Country: " . ($merchant->country ?? 'N/A') . "\n";
                
                echo "\nExample successful! You can now use this access token to make API calls.\n";
                echo "\nExample usage in your application:\n";
                echo "<?php\n";
                echo "\$sumup = new \\SumUp\\SumUp([\n";
                echo "    'access_token' => '" . $accessToken->getToken() . "',\n";
                echo "]);\n";
                echo "\n";
                echo "\$checkout = \$sumup->checkouts->create([\n";
                echo "    'amount' => 10.00,\n";
                echo "    'currency' => 'EUR',\n";
                echo "    'checkout_reference' => 'my-order-123',\n";
                echo "    'merchant_code' => '" . $merchantCode . "',\n";
                echo "    'description' => 'My product',\n";
                echo "]);\n";
                
            } else {
                echo "No merchant memberships found.\n";
            }

        } catch (Exception $e) {
            echo "Error fetching merchant information: " . $e->getMessage() . "\n";
            echo "The token is valid, but you may need additional permissions.\n";
        }

    } catch (Exception $e) {
        fwrite(STDERR, "OAuth2 Error: " . $e->getMessage() . "\n");
        exit(1);
    }
}

main();