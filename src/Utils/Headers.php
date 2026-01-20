<?php

namespace SumUp\Utils;

use SumUp\SdkInfo;

/**
 * Class Headers
 *
 * @package SumUp\Utils
 */
class Headers
{
    /**
     * Get the common header for Content-Type: application/json.
     *
     * @return array
     */
    public static function getCTJson()
    {
        return ['Content-Type' => 'application/json'];
    }

    /**
     * Get the authorization header with token.
     *
     * @param string $accessToken
     *
     * @return array
     */
    public static function getAuth($accessToken)
    {
        return ['Authorization' => 'Bearer ' . $accessToken];
    }

    /**
     * Get standard headers needed for every request.
     *
     * @return array
     */
    public static function getStandardHeaders()
    {
        $headers = self::getCTJson();
        $headers['User-Agent'] = SdkInfo::getUserAgent();
        return array_merge($headers, SdkInfo::getRuntimeHeaders());
    }
}
