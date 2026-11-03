<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The data type of a feature value. The wire `value` is always a string and is parsed
 * according to this type.
 */
enum FeatureV10ValueType: string
{
    case TEXT = 'TEXT';
    case INTEGER = 'INTEGER';
    case DECIMAL = 'DECIMAL';
    case DATE = 'DATE';
    case BOOLEAN = 'BOOLEAN';
}
