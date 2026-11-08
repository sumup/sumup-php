<?php

declare(strict_types=1);

namespace SumUp\Events;

/** A reference to the affected resource, rather than a snapshot of its data. */
final class EventObjectReference
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $url
    ) {
    }
}
