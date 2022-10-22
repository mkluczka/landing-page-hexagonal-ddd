<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage;

use LandingPage\Domain\Events;
use LandingPage\Domain\PublicationStatus;

class LandingPageFactory
{
    public function __construct(private readonly Events $events)
    {
    }

    public function newLandingPage(string $landingPageId): LandingPage
    {
        return new LandingPage(
            $landingPageId,
            PublicationStatus::UNPUBLISHED,
            $this->events,
        );
    }
}
