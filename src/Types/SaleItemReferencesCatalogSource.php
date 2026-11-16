<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The source of the catalog the line originates from.
 */
enum SaleItemReferencesCatalogSource: string
{
    case SUMUP = 'SUMUP';
    case EXTERNAL = 'EXTERNAL';
}
