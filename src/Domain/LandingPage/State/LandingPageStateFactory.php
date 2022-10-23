<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\State;

use LandingPage\Domain\Events;
use LandingPage\Domain\Name;

class LandingPageStateFactory
{
    public function __construct(private readonly Events $events)
    {
    }

    public function stateNew(string $id): NewLandingPage
    {
        return new NewLandingPage(
            $id,
            $this->events,
            $this
        );
    }

    public function statePublished(string $id): PublishedLandingPage
    {
        return new PublishedLandingPage($id, $this->events, $this);
    }

    public function stateUnpublished(string $id, ?string $templateId, Name $name): UnpublishedLandingPage
    {
        return new UnpublishedLandingPage(
            $id,
            $templateId,
            $name,
            $this->events,
            $this
        );
    }
}
