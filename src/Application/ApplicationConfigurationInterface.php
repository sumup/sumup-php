<?php

namespace SumUp\Application;

/**
 * Interface ApplicationConfigurationInterface
 *
 * @package SumUp\Application
 */
interface ApplicationConfigurationInterface
{
    /**
     * Returns the base URL of the SumUp API.
     *
     * @return string
     */
    public function getBaseURL();



    /**
     * Returns access token.
     *
     * @return string
     */
    public function getAccessToken();

    /**
     * Returns a flag whether to use GuzzleHttp over cURL if both are present.
     *
     * @return bool
     */
    public function getForceGuzzle();

    /**
     * Returns associative array with custom headers.
     *
     * @return array
     */
    public function getCustomHeaders();

    /**
     * Returns the path to the CA bundle used for HTTPS verification.
     *
     * @return string|null
     */
    public function getCABundlePath();

    /**
     * Returns the API key if set.
     *
     * @return string|null
     */
    public function getApiKey();
}
