<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\State;

use LandingPage\Domain\LandingPage\Event\LandingPageCreated;
use LandingPage\Domain\Name;

class NewLandingPage extends LandingPageState
{
    public function create(string $name): LandingPageState
    {
        $this->events->record(new LandingPageCreated(
            $this->id,
            $name,
        ));

        return $this->stateFactory->stateUnpublished(
            $this->id,
            null,
            new Name($name)
        );
    }
}
