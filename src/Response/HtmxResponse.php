<?php

/**
 * Docs: https://htmx.org/docs/#response-headers
 */

declare(strict_types=1);

namespace Htmxfony\Response;

use Htmxfony\Response\Header\HtmxLocation;
use Htmxfony\Response\Header\HtmxTrigger;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class HtmxResponse extends SymfonyResponse
{

    public const HX_LOCATION = 'HX-Location';
    public const HX_PUSH_URL = 'HX-Push-Url';
    public const HX_REPLACE_URL = 'HX-Replace-Url';
    public const HX_RESWAP = 'HX-Reswap';
    public const HX_RETARGET = 'HX-Retarget';
    public const HX_RESELECT = 'HX-Reselect';
    public const HX_TRIGGER = 'HX-Trigger';
    public const HX_TRIGGER_AFTER_SETTLE = 'HX-Trigger-After-Settle';
    public const HX_TRIGGER_AFTER_SWAP = 'HX-Trigger-After-Swap';

    public function setLocation(HtmxLocation $location): self
    {
        $this->headers->set(self::HX_LOCATION, (string) $location);

        return $this;
    }

    public function setPushUrl(string $url): self
    {
        $this->headers->set(self::HX_PUSH_URL, $url);

        return $this;
    }

    public function setReplaceUrl(string $url): self
    {
        $this->headers->set(self::HX_REPLACE_URL, $url);

        return $this;
    }

    public function setReSwap(string $option): self
    {
        $this->headers->set(self::HX_RESWAP, $option);

        return $this;
    }

    public function setReTarget(string $selector): self
    {
        $this->headers->set(self::HX_RETARGET, $selector);

        return $this;
    }

    public function setReSelect(string $selector): self
    {
        $this->headers->set(self::HX_RESELECT, $selector);

        return $this;
    }

    public function setTriggers(HtmxTrigger ...$triggers): self
    {
        $this->headers->set(self::HX_TRIGGER, json_encode($this->buildTriggers(...$triggers)));

        return $this;
    }

    public function setTriggersAfterSettle(HtmxTrigger ...$triggers): self
    {
        $this->headers->set(self::HX_TRIGGER_AFTER_SETTLE, json_encode($this->buildTriggers(...$triggers)));

        return $this;
    }

    public function setTriggerAfterSwap(HtmxTrigger ...$triggers): self
    {
        $this->headers->set(self::HX_TRIGGER_AFTER_SWAP, json_encode($this->buildTriggers(...$triggers)));

        return $this;
    }

    protected function buildTriggers(HtmxTrigger ...$triggers): array
    {
        $collection = [];
        foreach ($triggers as $trigger) {
            $collection[$trigger->getName()] = $trigger->getData();
        }

        return $collection;
    }

}
