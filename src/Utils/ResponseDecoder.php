<?php

namespace SumUp\Utils;

use SumUp\HttpClients\Response;

/**
 * Converts HTTP responses into SDK models or scalar values.
 */
class ResponseDecoder
{
    /**
     * Decode a response using the provided descriptor map.
     *
     * @param Response $response
     * @param array $descriptors
     *
     * @return mixed
     */
    public static function decode(Response $response, array $descriptors = [])
    {
        if (empty($descriptors)) {
            return $response;
        }

        $statusCode = (string) $response->getHttpResponseCode();
        $descriptor = null;
        if (isset($descriptors[$statusCode])) {
            $descriptor = $descriptors[$statusCode];
        } elseif (isset($descriptors['default'])) {
            $descriptor = $descriptors['default'];
        }

        if ($descriptor === null || !isset($descriptor['type'])) {
            return $response->getBody();
        }

        return self::castValue($response->getBody(), $descriptor);
    }

    /**
     * Convert the payload to the descriptor type.
     *
     * @param mixed $value
     * @param array $descriptor
     *
     * @return mixed
     */
    private static function castValue($value, array $descriptor)
    {
        switch ($descriptor['type']) {
            case 'class':
                if (!isset($descriptor['class'])) {
                    return $value;
                }

                return Hydrator::hydrate($value, ltrim($descriptor['class'], '\\'));
            case 'array':
                if (!is_array($value)) {
                    $value = $value instanceof \stdClass ? get_object_vars($value) : (array) $value;
                }

                if (!isset($descriptor['items']) || empty($descriptor['items'])) {
                    return $value;
                }

                $result = [];
                foreach ($value as $key => $item) {
                    $result[$key] = self::castValue($item, $descriptor['items']);
                }

                return $result;
            case 'scalar':
                return self::castScalar($value, isset($descriptor['scalar']) ? $descriptor['scalar'] : 'mixed');
            case 'object':
                if ($value instanceof \stdClass) {
                    return get_object_vars($value);
                }
                return is_array($value) ? $value : [];
            case 'void':
                return null;
            case 'mixed':
            default:
                return $value;
        }
    }

    /**
     * Cast scalar values to their expected PHP type.
     *
     * @param mixed $value
     * @param string $type
     *
     * @return mixed
     */
    private static function castScalar($value, $type)
    {
        switch ($type) {
            case 'string':
                return (string) $value;
            case 'int':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'bool':
                return (bool) $value;
            default:
                return $value;
        }
    }
}
