<?php

declare(strict_types=1);

namespace Htmxfony\Request;

use PHPUnit\Framework\TestCase;

class HtmxRequestTest extends TestCase
{

    public function testIsHtmxRequest(): void
    {
        $request = new HtmxRequest();
        $this->assertFalse($request->isHtmxRequest());

        $request->headers->set('HX-Request', 'true');
        $this->assertTrue($request->isHtmxRequest());
    }

    public function testIsBoosted(): void
    {
        $request = new HtmxRequest();
        $this->assertFalse($request->isBoosted());

        $request->headers->set('HX-Boosted', 'true');
        $this->assertTrue($request->isBoosted());
    }

    public function testGetCurrentUrl(): void
    {
        $request = new HtmxRequest();
        $this->assertNull($request->getCurrentUrl());

        $request->headers->set('HX-Current-URL', 'https://htmx.org');
        $this->assertSame('https://htmx.org', $request->getCurrentUrl());
    }

    public function testIsHistoryRestoreRequest(): void
    {
        $request = new HtmxRequest();
        $this->assertFalse($request->isHistoryRestoreRequest());

        $request->headers->set('HX-History-Restore-Request', 'true');
        $this->assertTrue($request->isHistoryRestoreRequest());
    }

    public function testGetPromptResponse(): void
    {
        $request = new HtmxRequest();
        $this->assertNull($request->getPromptResponse());

        $request->headers->set('HX-Prompt', 'true');
        $this->assertSame('true', $request->getPromptResponse());
    }

    public function testGetTargetId(): void
    {
        $request = new HtmxRequest();
        $this->assertNull($request->getTargetId());

        $request->headers->set('HX-Target', 'target-id');
        $this->assertSame('target-id', $request->getTargetId());
    }

    public function testGetTriggerName(): void
    {
        $request = new HtmxRequest();
        $this->assertNull($request->getTriggerName());

        $request->headers->set('HX-Trigger-Name', 'trigger-name');
        $this->assertSame('trigger-name', $request->getTriggerName());
    }

    public function testGetTriggerId(): void
    {
        $request = new HtmxRequest();
        $this->assertNull($request->getTriggerId());

        $request->headers->set('HX-Trigger', 'trigger-id');
        $this->assertSame('trigger-id', $request->getTriggerId());
    }

}
