<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of a link to a related resource.
 */
class Link
{
    /**
     * Specifies the relation to the current resource.
     *
     * @var string|null
     */
    public ?string $rel = null;

    /**
     * URL for accessing the related resource.
     *
     * @var string|null
     */
    public ?string $href = null;

    /**
     * Specifies the media type of the related resource.
     *
     * @var string|null
     */
    public ?string $type = null;

}
