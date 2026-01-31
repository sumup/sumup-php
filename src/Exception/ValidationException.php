<?php

namespace SumUp\Exception;

/**
 * Class ValidationException
 *
 * @package SumUp\Exception
 */
class ValidationException extends SDKException
{
    const VALIDATION_ERROR_BASE = 'Validation error in: ';
    /**
     * Fields that are not valid.
     *
     * @var array
     */
    protected $fields;

    /**
     * ValidationException constructor.
     *
     * @param array $fields
     * @param int   $code
     * @param null  $previous
     */
    public function __construct($fields = [], $code = 0, $previous = null)
    {
        $this->fields = $fields;
        $message = self::VALIDATION_ERROR_BASE . implode(', ', $fields);
        parent::__construct($message, $code, null, $previous);
    }

    /**
     * Returns the fields that failed the server validation.
     *
     * @return array
     */
    public function getInvalidFields()
    {
        return $this->fields;
    }
}
