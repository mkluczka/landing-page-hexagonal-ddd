<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage;

use LandingPage\Domain\Events;
use LandingPage\Domain\LandingPage\Event\LandingPageCreated;
use LandingPage\Domain\LandingPage\Event\LandingPagePublished;
use LandingPage\Domain\LandingPage\Event\LandingPageRepublished;
use LandingPage\Domain\LandingPage\Event\LandingPageTemplateChanged;
use LandingPage\Domain\Name;
use LandingPage\Domain\PublicationStatus;

class LandingPage
{
    public function __construct(
        private readonly string   $id,
        private PublicationStatus $status,
        private readonly Events   $events,
    )
    {
    }

    public function create(string $name): void
    {
        $landingName = new Name($name);

        $this->events->record(new LandingPageCreated(
            $this->id,
            $landingName->value,
        ));
    }

    public function changeTemplate(string $landingTemplateId): void
    {
        $this->events->record(new LandingPageTemplateChanged(
            $this->id,
            $landingTemplateId,
        ));
    }

    public function publish(): void
    {
        if ($this->status === PublicationStatus::PUBLISHED) {
            $this->events->record(new LandingPageRepublished($this->id));
            return;
        }

        $this->events->record(new LandingPagePublished($this->id));

        $this->status = PublicationStatus::PUBLISHED;
    }
}
