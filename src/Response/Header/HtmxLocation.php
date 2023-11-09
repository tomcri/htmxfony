<?php

/**
 * Docs: https://htmx.org/headers/hx-location/
 */

declare(strict_types=1);

namespace Htmxfony\Response\Header;

use JsonSerializable;

class HtmxLocation implements JsonSerializable
{

    private $path;

    private $source = null;

    private $event = null;

    private $handler = null;

    private $target = null;

    private $swap = null;

    private $values = null;

    private $headers = null;

    public function __construct(
        string $path,
        ?string $source = null,
        ?string $event = null,
        ?string $handler = null,
        ?string $target = null,
        ?string $swap = null,
        ?array $values = null,
        ?array $headers = null
    ) {
        $this->headers = $headers;
        $this->values = $values;
        $this->swap = $swap;
        $this->target = $target;
        $this->handler = $handler;
        $this->event = $event;
        $this->source = $source;
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function getHandler(): ?string
    {
        return $this->handler;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function getSwap(): ?string
    {
        return $this->swap;
    }

    public function getValues(): ?array
    {
        return $this->values;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'path'    => $this->getPath(),
            'source'  => $this->getSource(),
            'event'   => $this->getEvent(),
            'handler' => $this->getHandler(),
            'target'  => $this->getTarget(),
            'swap'    => $this->getSwap(),
            'values'  => $this->getValues(),
            'headers' => $this->getHeaders(),
        ];

        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }

    public function __toString(): string
    {
        return json_encode($this);
    }

}
