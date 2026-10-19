<?php

declare(strict_types=1);

namespace SumUp\Exception;

/** The signing timestamp is outside the five-minute window. */
class EventSignatureExpiredException extends EventSignatureException
{
}
