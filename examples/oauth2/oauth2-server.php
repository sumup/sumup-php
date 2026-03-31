<?php

/**
 * OAuth 2.0 Authorization Code flow with SumUp
 *
 * This example shows the minimal flow required to authenticate a user,
 * exchange the authorization code for an access token, and use that token
 * with the SumUp PHP SDK.
 *
 * Required environment variables:
 * - CLIENT_ID
 * - CLIENT_SECRET
 * - REDIRECT_URI
 *
 * Run:
 * php -S localhost:8080 oauth2-server.php
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use League\OAuth2\Client\Provider\GenericProvider;

const STATE_SESSION_KEY = 'oauth_state';
const PKCE_SESSION_KEY = 'oauth_pkce';
const SCOPES = 'email profile';

session_set_cookie_params([
    'path' => '/',
    'httponly' => true,
    'secure' => false,
    'samesite' => 'Lax',
]);
session_start();

$clientId = getenv('CLIENT_ID');
$clientSecret = getenv('CLIENT_SECRET');
$redirectUri = getenv('REDIRECT_URI');

if (!$clientId || !$clientSecret || !$redirectUri) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Missing CLIENT_ID, CLIENT_SECRET or REDIRECT_URI environment variables';
    exit;
}

$provider = new GenericProvider([
    'clientId' => $clientId,
    'clientSecret' => $clientSecret,
    'redirectUri' => $redirectUri,
    'urlAuthorize' => 'https://api.sumup.com/authorize',
    'urlAccessToken' => 'https://api.sumup.com/token',
    'urlResourceOwnerDetails' => '',
]);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

switch ($path) {
    case '/':
        renderHome();
        break;

    case '/login':
        handleLogin($provider);
        break;

    case '/callback':
        handleCallback($provider);
        break;

    default:
        http_response_code(404);
        echo 'Not Found';
}

function renderHome(): void
{
    echo '<!doctype html>';
    echo '<html lang="en">';
    echo '<head><meta charset="utf-8"><title>SumUp OAuth2 Example</title></head>';
    echo '<body>';
    echo '<h1>SumUp OAuth2 Example</h1>';
    echo '<p>This example demonstrates the Authorization Code flow with PKCE.</p>';
    echo '<p><a href="/login">Start OAuth2 Flow</a></p>';
    echo '</body>';
    echo '</html>';
}

function handleLogin(GenericProvider $provider): void
{
    $provider->pkceMethod = GenericProvider::PKCE_METHOD_S256;

    $authorizationUrl = $provider->getAuthorizationUrl([
        'scope' => SCOPES,
    ]);
    $_SESSION[STATE_SESSION_KEY] = $provider->getState();
    $_SESSION[PKCE_SESSION_KEY] = $provider->getPkceCode();

    header('Location: ' . $authorizationUrl, true, 302);
    exit;
}

function handleCallback(GenericProvider $provider): void
{
    $state = $_GET['state'] ?? '';
    $expectedState = $_SESSION[STATE_SESSION_KEY] ?? '';

    if ($state === '' || !hash_equals($expectedState, $state)) {
        http_response_code(400);
        echo 'Invalid OAuth state parameter';
        return;
    }

    $code = $_GET['code'] ?? '';
    if ($code === '') {
        http_response_code(400);
        echo 'Missing authorization code';
        return;
    }

    $codeVerifier = $_SESSION[PKCE_SESSION_KEY] ?? '';
    if ($codeVerifier === '') {
        http_response_code(400);
        echo 'Missing PKCE code verifier';
        return;
    }

    $merchantCode = $_GET['merchant_code'] ?? '';
    if ($merchantCode === '') {
        http_response_code(400);
        echo 'Missing merchant_code query parameter';
        return;
    }

    try {
        $provider->pkceMethod = GenericProvider::PKCE_METHOD_S256;
        $provider->setPkceCode($codeVerifier);

        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        $sumup = new \SumUp\SumUp([
            'access_token' => $accessToken->getToken(),
        ]);

        $merchant = $sumup->merchants()->get($merchantCode);

        unset($_SESSION[STATE_SESSION_KEY], $_SESSION[PKCE_SESSION_KEY]);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'merchant_code' => $merchantCode,
            'merchant' => $merchant,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    } catch (Exception $e) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'OAuth2 error: ' . $e->getMessage();
    }
}
