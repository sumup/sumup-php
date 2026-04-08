<?php

declare(strict_types=1);

namespace SumUp\Types;

enum FinancialPayoutsItemStatus: string
{
    case SUCCESSFUL = 'SUCCESSFUL';
    case FAILED = 'FAILED';
}
