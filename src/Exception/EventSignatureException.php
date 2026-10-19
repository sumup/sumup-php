<?php

declare(strict_types=1);

namespace SumUp\Exception;

/** Missing signing secret, malformed header, or invalid signature. */
class EventSignatureException extends EventException
{
}
