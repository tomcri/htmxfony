<?php

/**
 * Docs: https://htmx.org/docs/#response-headers
 */

declare(strict_types=1);

namespace Htmxfony\Response;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class HtmxStopPollingResponse extends SymfonyResponse
{
    public const HX_CODE_STOP_POLLING = 286;

    public function __construct()
    {
        parent::__construct('', self::HX_CODE_STOP_POLLING);
    }

}
