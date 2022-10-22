<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\Event;

use LandingPage\Domain\DomainEvent;

final class LandingPageAddedToUserLandingPages implements DomainEvent
{
    public function __construct(
        public readonly string $landingPageId,
        public readonly string $userId,
    )
    {
    }

    public function getEventName(): string
    {
        return 'landing_page_added_to_user_landing_pages';
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->landingPageId,
            'userId' => $this->userId,
        ];
    }
}
