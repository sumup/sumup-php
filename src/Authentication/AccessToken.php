<?php

namespace SumUp\Authentication;

/**
 * Class AccessToken
 *
 * @package SumUp\Authentication
 */
class AccessToken
{
    /**
     * The access token value.
     *
     * @var string
     */
    protected $value = '';

    /**
     * Create a new access token entity.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the access token.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the type of the access token (always Bearer for SumUp API).
     *
     * @return string
     */
    public function getType()
    {
        return 'Bearer';
    }


}
