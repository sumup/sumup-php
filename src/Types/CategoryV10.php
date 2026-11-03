<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * A category a line belongs to.
 */
class CategoryV10
{
    /**
     * The category id. Usually a UUID, but not always (legacy cases).
     *
     * @var string
     */
    public string $id;

    /**
     * The category name.
     *
     * @var string
     */
    public string $name;

}
