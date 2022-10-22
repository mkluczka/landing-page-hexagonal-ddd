<?php

declare(strict_types=1);

namespace LandingPage\Domain;

interface DomainEvent
{
    public function getEventName(): string;

    public function getPayload(): array;
}
