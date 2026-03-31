# OAuth2 Example for SumUp PHP SDK

This example demonstrates the OAuth 2.0 Authorization Code flow with PKCE using `league/oauth2-client`, then uses the resulting access token with the SumUp PHP SDK.

## Requirements

Set these environment variables before running the example:

```bash
export CLIENT_ID="your_client_id"
export CLIENT_SECRET="your_client_secret"
export REDIRECT_URI="http://localhost:8080/callback"
```

The redirect URI must match the one configured for your OAuth2 application in the SumUp Developer Settings.

## Run

```bash
cd examples/oauth2
php -S localhost:8080 oauth2-server.php
```

Then open `http://localhost:8080/` and start the flow.

## Flow

The example exposes two routes:

- `/login` generates a state value and PKCE verifier, then redirects to SumUp authorization.
- `/callback` verifies the state, exchanges the code for an access token, and fetches the merchant identified by `merchant_code`.

## Notes

- The example relies on `league/oauth2-client` to generate state and PKCE parameters and to exchange the authorization code for a token.
- The example requests the `email profile` scope.
- The access token is passed directly into `new \SumUp\SumUp([ 'access_token' => ... ])`.
- The response includes the fetched merchant payload as JSON.
