<?php

declare(strict_types=1);

namespace LandingPage\Application;

use LandingPage\Domain\LandingPage\LandingPagesRepository;
use LandingPage\Ports\Command\PublishLandingPage;

final class PublishLandingPageHandler
{
    public function __construct(private readonly LandingPagesRepository $landingPagesRepository)
    {
    }

    public function handle(PublishLandingPage $command): void
    {
        $this->landingPagesRepository
            ->getOne($command->landingPageId)
            ->publish();
    }
}
