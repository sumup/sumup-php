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
     * The access token type.
     *
     * @var string
     */
    protected $type = 'Bearer';

    /**
     * Create a new access token entity.
     *
     * @param string $value
     * @param string $type
     */
    public function __construct($value, $type = 'Bearer')
    {
        $this->value = $value;
        $this->type = $type;
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
     * Returns the type of the access token.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


}
