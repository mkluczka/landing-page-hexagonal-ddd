<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage;

use LandingPage\Domain\LandingPage\State\LandingPageState;

class LandingPage
{
    public function __construct(private LandingPageState $state)
    {
    }

    public function create(string $name): void
    {
        $this->state = $this->state->create($name);
    }

    public function changeTemplate(string $landingTemplateId): void
    {
        $this->state = $this->state->changeTemplate($landingTemplateId);
    }

    public function publish(): void
    {
        $this->state = $this->state->publish();
    }
}
