<?php

declare(strict_types=1);

namespace LandingPage\Infrastructure;

use LandingPage\Domain\Events;
use LandingPage\Domain\LandingPage\LandingPage;
use LandingPage\Domain\LandingPage\LandingPageCollection;
use LandingPage\Domain\LandingPage\LandingPageFactory;
use LandingPage\Domain\LandingPage\LandingPagesRepository;
use LandingPage\Domain\LandingPage\Template\LandingTemplateFactory;
use LandingPage\Domain\PublicationStatus;

final class LandingPagesFixedRepository implements LandingPagesRepository
{
    public const PUBLISHED_LANDING_PAGE_ID = '435191ec-c974-49d9-93f1-543c4c1ec820';

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
        return new LandingPage(
            $landingPageId,
            $landingPageId === self::PUBLISHED_LANDING_PAGE_ID ? PublicationStatus::PUBLISHED : PublicationStatus::UNPUBLISHED,
            $this->events
        );
    }
}
