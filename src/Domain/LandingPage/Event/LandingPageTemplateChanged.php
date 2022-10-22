<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\Event;

use LandingPage\Domain\DomainEvent;

final class LandingPageTemplateChanged implements DomainEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $landingTemplateId,
    )
    {
    }

    public function getEventName(): string
    {
        return 'landing_page_template_changed';
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->id,
            'templateId' => $this->landingTemplateId,
        ];
    }
}
