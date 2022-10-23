<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage\State;

use LandingPage\Domain\Events;
use LandingPage\Domain\Exception\LandingPageException;

abstract class LandingPageState
{
    public function __construct(
        protected readonly string                  $id,
        protected readonly Events                  $events,
        protected readonly LandingPageStateFactory $stateFactory,
    )
    {
    }

    public function create(string $name): LandingPageState
    {
        throw LandingPageException::actionNotAllowedForState('create', static::class);
    }

    public function changeTemplate(string $landingTemplateId): LandingPageState
    {
        throw LandingPageException::actionNotAllowedForState('changeTemplate', static::class);
    }

    public function publish(): LandingPageState
    {
        throw LandingPageException::actionNotAllowedForState('publish', static::class);
    }
}
