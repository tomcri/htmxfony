<?php

declare(strict_types=1);

namespace Htmxfony\Tests\Response;

use Htmxfony\Response\Header\HtmxLocation;
use Htmxfony\Response\Header\HtmxTrigger;
use Htmxfony\Response\HtmxResponse;
use PHPUnit\Framework\TestCase;

class HtmxResponseTest extends TestCase
{

    public function testSetLocation(): void
    {
        $response = new HtmxResponse();
        $response->setLocation(new HtmxLocation('https://htmx.org'));
        $this->assertSame(json_encode(new HtmxLocation('https://htmx.org')), $response->headers->get(HtmxResponse::HX_LOCATION));
    }

    public function testSetPushUrl(): void
    {
        $response = new HtmxResponse();
        $response->setPushUrl('https://htmx.org');
        $this->assertSame('https://htmx.org', $response->headers->get(HtmxResponse::HX_PUSH_URL));
    }

    public function testReplaceUrl(): void
    {
        $response = new HtmxResponse();
        $response->setReplaceUrl('https://htmx.org');
        $this->assertSame('https://htmx.org', $response->headers->get(HtmxResponse::HX_REPLACE_URL));
    }

    public function testReSwap(): void
    {
        $response = new HtmxResponse();
        $response->setReSwap('outerHTML');
        $this->assertSame('outerHTML', $response->headers->get(HtmxResponse::HX_RESWAP));
    }

    public function testReTarget(): void
    {
        $response = new HtmxResponse();
        $response->setReTarget('#target');
        $this->assertSame('#target', $response->headers->get(HtmxResponse::HX_RETARGET));
    }

    public function testReSelect(): void
    {
        $response = new HtmxResponse();
        $response->setReSelect('#target');
        $this->assertSame('#target', $response->headers->get(HtmxResponse::HX_RESELECT));
    }

    public function testTrigger(): void
    {
        $responseHelper = new class extends HtmxResponse {

            public function buildTriggers(HtmxTrigger ...$triggers): array
            {
                return parent::buildTriggers(...$triggers);
            }

        };

        $triggers = [
            new HtmxTrigger('myEvent'),
            new HtmxTrigger('myEvent'),
        ];

        $expected = json_encode(
            $responseHelper->buildTriggers(...$triggers)
        );

        $response = new HtmxResponse();
        $response->setTriggers(...$triggers);
        $this->assertSame($expected, $response->headers->get(HtmxResponse::HX_TRIGGER));

        $response->setTriggersAfterSettle(...$triggers);
        $this->assertSame($expected, $response->headers->get(HtmxResponse::HX_TRIGGER_AFTER_SETTLE));

        $response->setTriggerAfterSwap(...$triggers);
        $this->assertSame($expected, $response->headers->get(HtmxResponse::HX_TRIGGER_AFTER_SWAP));
    }

}
