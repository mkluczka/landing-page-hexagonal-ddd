<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\State;

use LandingPage\Domain\Events;
use LandingPage\Domain\LandingPage\Event\LandingPagePublished;
use LandingPage\Domain\LandingPage\Event\LandingPageTemplateChanged;
use LandingPage\Domain\Name;

class UnpublishedLandingPage extends LandingPageState
{
    public function __construct(
        string                  $id,
        public readonly ?string $landingTemplateId,
        public readonly Name    $name,
        Events                  $events,
        LandingPageStateFactory $stateFactory,
    )
    {
        parent::__construct($id, $events, $stateFactory);
    }

    public function changeTemplate(string $landingTemplateId): UnpublishedLandingPage
    {
        $this->events->record(new LandingPageTemplateChanged(
            $this->id,
            $landingTemplateId,
        ));

        return $this->stateFactory->stateUnpublished($this->id, $landingTemplateId, $this->name);
    }

    public function publish(): LandingPageState
    {
        $this->events->record(new LandingPagePublished($this->id));

        return $this->stateFactory->statePublished($this->id);
    }
}
