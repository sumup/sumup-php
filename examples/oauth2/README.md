# OAuth 2.0 Examples for SumUp PHP SDK

This directory contains examples demonstrating how to implement OAuth 2.0 Authorization Code flow with the SumUp PHP SDK.

## Prerequisites

Before running these examples, you need:

1. **Client Credentials**: Create an OAuth2 application in the [SumUp Developer Settings](https://me.sumup.com/en-us/settings/oauth2-applications)
2. **Redirect URI**: Configure your application with the correct redirect URI:
   - For web server example: `http://localhost:8080/callback`
   - For CLI example: `urn:ietf:wg:oauth:2.0:oob`

## Examples

### 1. Web Server Example (`oauth2-server.php`)

A complete web-based OAuth2 implementation with a built-in web server.

**Setup:**
```bash
export CLIENT_ID="your_client_id"
export CLIENT_SECRET="your_client_secret"
export REDIRECT_URI="http://localhost:8080/callback"  # Optional, defaults to localhost
```

**Run:**
```bash
cd examples/oauth2
php -S localhost:8080 oauth2-server.php
```

**Usage:**
1. Open http://localhost:8080 in your browser
2. Click "Start OAuth2 Flow"
3. Authorize the application on SumUp
4. View merchant information and token details

**Features:**
- Complete OAuth2 Authorization Code flow with PKCE
- CSRF protection with state parameter
- Session-based state management
- Merchant information display
- Example API usage

### 2. Command Line Example (`oauth2-cli.php`)

A simpler command-line OAuth2 implementation similar to the Go SDK example.

**Setup:**
```bash
export CLIENT_ID="your_client_id"
export CLIENT_SECRET="your_client_secret"
```

**Run:**
```bash
cd examples/oauth2
php oauth2-cli.php
```

**Usage:**
1. Run the script
2. Copy the authorization URL and open it in your browser
3. Authorize the application
4. Copy the authorization code from the redirect page
5. Paste it back into the terminal

**Features:**
- OAuth2 Authorization Code flow with PKCE
- Out-of-band redirect for CLI applications
- Interactive authorization code input
- Basic merchant information retrieval
- Example code generation

## OAuth 2.0 Flow Overview

Both examples implement the Authorization Code flow with PKCE (Proof Key for Code Exchange):

1. **Authorization Request**: User is redirected to SumUp's authorization server
2. **User Authorization**: User logs in and grants permissions
3. **Authorization Code**: SumUp redirects back with an authorization code
4. **Token Exchange**: Application exchanges the code for an access token
5. **API Access**: Use the access token with the SumUp SDK

## Security Features

- **PKCE (RFC 7636)**: Prevents authorization code interception attacks
- **State Parameter**: Prevents CSRF attacks
- **Secure Cookie Settings**: HttpOnly, SameSite protection (web example)
- **Session Management**: Proper cleanup of sensitive data

## Scopes

The examples request these scopes:
- `payments`: Create and manage payments/checkouts
- `transactions.history`: Access transaction history
- `user.profile_readonly`: Read user profile information
- `user.app-settings`: Access application settings

Adjust the scopes based on your application's needs. Always request the minimum required permissions.

## Integration with Your Application

After obtaining an access token, use it with the SumUp SDK:

```php
<?php

// Option 1: Pass token during SDK initialization
$sumup = new \SumUp\SumUp([
    'access_token' => $accessToken,
]);

// Option 2: Set token later
$sumup = new \SumUp\SumUp();
$sumup->setDefaultAccessToken($accessToken);

// Option 3: Override token per service call
$checkouts = $sumup->getService('checkouts', $accessToken);

// Use the SDK normally
$checkout = $sumup->checkouts->create([
    'amount' => 10.00,
    'currency' => 'EUR',
    'checkout_reference' => 'order-123',
    'merchant_code' => $merchantCode,
]);
```

## Token Storage

In production applications:

1. **Store tokens securely** (encrypted database, secure session storage)
2. **Handle token expiration** (implement refresh token logic)
3. **Protect refresh tokens** (encrypt, rotate regularly)
4. **Implement proper logout** (revoke tokens on logout)

## Dependencies

These examples use the [League OAuth2 Client](https://oauth2-client.thephpleague.com/) library:

```bash
composer require league/oauth2-client
```

## Production Considerations

- Use HTTPS in production
- Set secure cookie flags
- Implement proper error handling
- Log security events
- Validate all input parameters
- Use environment variables for sensitive configuration
- Implement rate limiting
- Monitor for suspicious activity

## Troubleshooting

**Common Issues:**

1. **Invalid redirect URI**: Ensure your OAuth2 app is configured with the correct redirect URI
2. **Invalid client credentials**: Check your CLIENT_ID and CLIENT_SECRET
3. **Scope errors**: Verify your application has been granted the requested scopes
4. **Token expiration**: Implement refresh token logic for long-running applications
5. **CORS issues**: Ensure proper CORS configuration for web applications

**Debug Tips:**

- Enable error reporting: `error_reporting(E_ALL);`
- Check SumUp API logs in your developer dashboard
- Validate OAuth2 parameters match your app configuration
- Test with different browsers/incognito mode