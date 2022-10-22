<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\Template\Event;

use LandingPage\Domain\DomainEvent;

final class LandingTemplateCreated implements DomainEvent
{
    public function __construct(public readonly string $id)
    {
    }

    public function getEventName(): string
    {
        return 'landing_template_created';
    }

    public function getPayload(): array
    {
        return [
            'templateId' => $this->id,
        ];
    }
}
