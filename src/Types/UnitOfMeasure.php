<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The unit of measure of the item.
 */
class UnitOfMeasure
{
    /**
     * The group of the unit of measure.
     *
     * @var string
     */
    public string $groupId;

    /**
     * The specific unit of measure within the group.
     *
     * @var string
     */
    public string $unitId;

    /**
     * The ratio of the specified unit to the base unit of the group.
     *
     * @var float
     */
    public float $unitRatio;

}
