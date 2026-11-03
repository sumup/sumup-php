<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Modifier set attached to an item.
 */
class ModifierSet
{
    /**
     * The id of the modifier set that modifier belongs to.
     *
     * @var string
     */
    public string $id;

    /**
     * The name of the modifier set that the modifier belongs to.
     *
     * @var string
     */
    public string $name;

}
