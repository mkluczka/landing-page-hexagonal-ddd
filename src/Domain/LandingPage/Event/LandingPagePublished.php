<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\Event;

use LandingPage\Domain\DomainEvent;

final class LandingPagePublished implements DomainEvent
{
    public function __construct(public readonly string $landingPageId)
    {
    }

    public function getEventName(): string
    {
        return 'landing_page_published';
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->landingPageId,
        ];
    }
}
