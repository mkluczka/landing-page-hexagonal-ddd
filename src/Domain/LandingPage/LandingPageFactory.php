<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage;

use LandingPage\Domain\LandingPage\State\LandingPageStateFactory;
use LandingPage\Domain\Name;

class LandingPageFactory
{
    public const PUBLISHED_LANDING_PAGE_ID = '435191ec-c974-49d9-93f1-543c4c1ec820';

    public function __construct(private readonly LandingPageStateFactory $stateFactory)
    {
    }

    public function newLandingPage(string $landingPageId): LandingPage
    {
        return new LandingPage(
            $this->stateFactory->stateNew($landingPageId)
        );
    }

    public function fromExisting(string $landingPageId): LandingPage
    {
        if ($landingPageId === self::PUBLISHED_LANDING_PAGE_ID) {
            return new LandingPage(
                $this->stateFactory->statePublished($landingPageId)
            );
        }

        return new LandingPage(
            $this->stateFactory->stateUnpublished($landingPageId, null, new Name('abcd'))
        );
    }
}
