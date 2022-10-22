<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\Template;

use LandingPage\Domain\Events;
use LandingPage\Domain\IdFactory;

class LandingTemplateFactory
{
    public function __construct(
        private readonly Events    $events,
        private readonly IdFactory $idFactory,
    )
    {
    }

    public function newLandingTemplate(): LandingTemplate
    {
        return new LandingTemplate(
            $this->idFactory->generateId(),
            $this->events
        );
    }
}
