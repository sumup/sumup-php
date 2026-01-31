<?php

declare(strict_types=1);

namespace SumUp\Types;

enum OperatorAccountType: string
{
    case OPERATOR = 'operator';
    case NORMAL = 'normal';
}
