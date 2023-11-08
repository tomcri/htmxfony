<?php

declare(strict_types=1);

namespace Htmxfony\Tests\Response;

use Htmxfony\Response\HtmxStopPollingResponse;
use PHPUnit\Framework\TestCase;

class HtmxStopPollingResponseTest extends TestCase
{

    public function testStopPollingStatusCode(): void
    {
        $response = new HtmxStopPollingResponse();
        $this->assertSame(HtmxStopPollingResponse::HX_CODE_STOP_POLLING, $response->getStatusCode());
    }

}
