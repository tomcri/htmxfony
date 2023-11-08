<?php

/**
 * Docs: https://htmx.org/headers/hx-location/
 */

declare(strict_types=1);

namespace Htmxfony\Response\Header;

use JsonSerializable;

class HtmxLocation implements JsonSerializable
{

    public function __construct(
        private readonly string $path,
        private readonly ?string $source = null,
        private readonly ?string $event = null,
        private readonly ?string $handler = null,
        private readonly ?string $target = null,
        private readonly ?string $swap = null,
        private readonly ?array $values = null,
        private readonly ?array $headers = null,
    ) {
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

        return array_filter($data, fn($value) => $value !== null);
    }

    public function __toString(): string
    {
        return json_encode($this);
    }

}
