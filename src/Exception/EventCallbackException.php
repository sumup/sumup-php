<?php

declare(strict_types=1);

namespace SumUp\Exception;

/** Event processing failed. The original failure is available through getPrevious(). */
class EventCallbackException extends EventException
{
}
