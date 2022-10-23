<?php

declare(strict_types=1);

namespace LandingPage\Infrastructure;

use LandingPage\Domain\Events;
use LandingPage\Domain\LandingPage\LandingPage;
use LandingPage\Domain\LandingPage\LandingPageCollection;
use LandingPage\Domain\LandingPage\LandingPageFactory;
use LandingPage\Domain\LandingPage\LandingPagesRepository;
use LandingPage\Domain\LandingPage\Template\LandingTemplateFactory;

final class LandingPagesFixedRepository implements LandingPagesRepository
{
    public function __construct(
        private readonly LandingPageFactory     $landingPageFactory,
        private readonly LandingTemplateFactory $landingTemplateFactory,
        private readonly Events                 $events,
    )
    {
    }

    public function getCollection(string $userId): LandingPageCollection
    {
        return new LandingPageCollection(
            $userId,
            [],
            $this->landingPageFactory,
            $this->landingTemplateFactory,
            $this->events,
        );
    }

    public function getOne(string $landingPageId): LandingPage
    {
        return $this->landingPageFactory->fromExisting($landingPageId);
    }
}
