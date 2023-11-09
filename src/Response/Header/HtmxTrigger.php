<?php

/**
 * Docs: https://htmx.org/headers/hx-trigger/
 */

declare(strict_types=1);

namespace Htmxfony\Response\Header;

use JsonSerializable;

class HtmxTrigger
{

    private $name;

    private $data = null;

    /**
     * @param string $name
     * @param null|string|array|JsonSerializable $data
     */
    public function __construct(
        string $name,
        $data = null
    ) {
        $this->data = $data;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array|JsonSerializable|string|null
     */
    public function getData()
    {
        return $this->data;
    }

}
