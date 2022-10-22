<?php

declare(strict_types=1);

namespace LandingPage\Application;

use LandingPage\Domain\Exception\LandingPageException;
use LandingPage\Domain\LandingPage\LandingPagesRepository;
use LandingPage\Domain\SourceTemplate\SourceTemplatesRepository;
use LandingPage\Ports\Command\CreateLandingPage;

final class CreateLandingPageHandler
{
    public function __construct(
        private readonly LandingPagesRepository    $landingPagesRepository,
        private readonly SourceTemplatesRepository $sourceTemplatesRepository,
    )
    {
    }

    public function handle(CreateLandingPage $command): void
    {
        $sourceTemplate = $this->sourceTemplatesRepository->getById($command->sourceTemplateId);
        if ($sourceTemplate === null) {
            throw LandingPageException::sourceTemplateNotFound($command->sourceTemplateId);
        }

        $this->landingPagesRepository
            ->getCollection($command->userId)
            ->addLandingPage($command->langingPageId, $sourceTemplate, $command->landingName);
    }
}
