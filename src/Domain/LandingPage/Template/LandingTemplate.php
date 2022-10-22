<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\Template;

use LandingPage\Domain\Events;
use LandingPage\Domain\LandingPage\Template\Event\LandingTemplateCreated;
use LandingPage\Domain\SourceTemplate\SourceTemplate;

class LandingTemplate
{
    public function __construct(
        private readonly string $id,
        private readonly Events $events,
    )
    {
    }

    public function createFromSourceTemplate(SourceTemplate $sourceTemplate): string
    {
        $this->events->record(new LandingTemplateCreated(
            $this->id
        ));

        return $this->id;
    }
}
