<?php

declare(strict_types=1);

namespace LandingPage\Ports\Command;

use App\EventStore\EventStoreTransaction;

#[EventStoreTransaction]
final class CreateLandingPage
{
    public function __construct(
        public readonly string $langingPageId,
        public readonly string $sourceTemplateId,
        public readonly string $landingName,
        public readonly string $userId,
    )
    {

    }
}
