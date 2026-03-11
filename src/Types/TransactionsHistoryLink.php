<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Hypermedia link used for transaction history pagination.
 */
class TransactionsHistoryLink
{
    /**
     * Relation.
     *
     * @var string
     */
    public string $rel;

    /**
     * Location.
     *
     * @var string
     */
    public string $href;

}
