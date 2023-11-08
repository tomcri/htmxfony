<?php

/**
 * Docs: https://htmx.org/docs/#request-headers
 */

declare(strict_types=1);

namespace Htmxfony\Request;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class HtmxRequest extends SymfonyRequest
{

    public const HX_BOOSTED = 'HX-Boosted';
    public const HX_CURRENT_URL = 'HX-Current-URL';
    public const HX_HISTORY_RESTORE_REQUEST = 'HX-History-Restore-Request';
    public const HX_PROMPT = 'HX-Prompt';
    public const HX_REQUEST = 'HX-Request';
    public const HX_TARGET = 'HX-Target';
    public const HX_TRIGGER_NAME = 'HX-Trigger-Name';
    public const HX_TRIGGER = 'HX-Trigger';

    public function isBoosted(): bool
    {
        return $this->headers->get(self::HX_BOOSTED) === 'true';
    }

    public function getCurrentUrl(): ?string
    {
        return $this->headers->get(self::HX_CURRENT_URL);
    }

    public function isHistoryRestoreRequest(): bool
    {
        return $this->headers->get(self::HX_HISTORY_RESTORE_REQUEST) === 'true';
    }

    public function getPromptResponse(): ?string
    {
        return $this->headers->get(self::HX_PROMPT);
    }

    public function isHtmxRequest(): bool
    {
        return $this->headers->get(self::HX_REQUEST) === 'true';
    }

    public function getTargetId(): ?string
    {
        return $this->headers->get(self::HX_TARGET);
    }

    public function getTriggerName(): ?string
    {
        return $this->headers->get(self::HX_TRIGGER_NAME);
    }

    public function getTriggerId(): ?string
    {
        return $this->headers->get(self::HX_TRIGGER);
    }

}
