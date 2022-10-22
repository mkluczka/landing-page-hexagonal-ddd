<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\Event;

use LandingPage\Domain\DomainEvent;

final class LandingPageCreated implements DomainEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    )
    {
    }

    public function getEventName(): string
    {
        return 'landing_page_created';
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
