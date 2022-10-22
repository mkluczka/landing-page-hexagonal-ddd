<?php

declare(strict_types=1);

namespace App\EventStore;

use LandingPage\Domain\DomainEvent;
use LandingPage\Domain\Events;

final class LandingPageEventStore implements Events
{
    public function __construct(private readonly EventStore $eventStore)
    {
    }

    public function record(DomainEvent $event): void
    {
        $this->eventStore->record($event->getEventName(), $event->getPayload());
    }
}
