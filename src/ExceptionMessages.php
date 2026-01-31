<?php

namespace SumUp;

/**
 * Class ExceptionMessages
 *
 * @package SumUp
 */
class ExceptionMessages
{
    /**
     * Get formatted message for missing parameter.
     *
     * @param $missingParamName
     *
     * @return string
     */
    public static function getMissingParamMsg($missingParamName)
    {
        return 'Missing parameter: "' . $missingParamName . '".';
    }
}
