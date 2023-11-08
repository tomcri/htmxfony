<?php

/**
 * Docs: https://htmx.org/headers/hx-trigger/
 */

declare(strict_types=1);

namespace Htmxfony\Response\Header;

use JsonSerializable;

class HtmxTrigger
{

    public function __construct(
        private readonly string $name,
        private readonly null|string|array|JsonSerializable $data = null,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): null|string|array|JsonSerializable
    {
        return $this->data;
    }

}
