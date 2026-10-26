<?php

declare(strict_types=1);

namespace SumUp\Types;

class StatusResponseData
{
    /**
     * Battery level percentage
     *
     * @var float|null
     */
    public ?float $batteryLevel = null;

    /**
     * Battery temperature in Celsius
     *
     * @var int|null
     */
    public ?int $batteryTemperature = null;

    /**
     * Type of connection used by the device
     *
     * @var StatusResponseDataConnectionType|string|null
     */
    public StatusResponseDataConnectionType|string|null $connectionType = null;

    /**
     * Firmware version of the device
     *
     * @var string|null
     */
    public ?string $firmwareVersion = null;

    /**
     * Timestamp of the last activity from the device
     *
     * @var string|null
     */
    public ?string $lastActivity = null;

    /**
     * Latest state of the device
     *
     * @var StatusResponseDataState|string|null
     */
    public StatusResponseDataState|string|null $state = null;

    /**
     * Status of a device
     *
     * @var StatusResponseDataStatus|string
     */
    public StatusResponseDataStatus|string $status;

}
