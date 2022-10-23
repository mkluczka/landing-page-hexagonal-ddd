<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\State;

use LandingPage\Domain\LandingPage\Event\LandingPageRepublished;

class PublishedLandingPage extends LandingPageState
{
    public function publish(): LandingPageState
    {
        $this->events->record(new LandingPageRepublished($this->id));

        return $this->stateFactory->statePublished($this->id);
    }
}
