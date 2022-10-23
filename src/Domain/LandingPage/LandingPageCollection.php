<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage;

use LandingPage\Domain\Events;
use LandingPage\Domain\Exception\LandingPageException;
use LandingPage\Domain\LandingPage\Event\LandingPageAddedToUserLandingPages;
use LandingPage\Domain\LandingPage\Template\LandingTemplateFactory;
use LandingPage\Domain\SourceTemplate\SourceTemplate;

class LandingPageCollection
{
    /**
     * @param array<string> $collection
     */
    public function __construct(
        private readonly string                 $userId,
        private array                           $collection,
        private readonly LandingPageFactory     $landingPageFactory,
        private readonly LandingTemplateFactory $landingTemplateFactory,
        private readonly Events                 $events,
    )
    {
    }

    public function addLandingPage(string $langingPageId, SourceTemplate $sourceTemplate, string $name): void
    {
        if (isset($this->collection[$langingPageId])) {
            throw LandingPageException::landingPageIdIsAlreadyUsed($langingPageId);
        }

        $landingTemplateId = $this->landingTemplateFactory
            ->newLandingTemplate()
            ->createFromSourceTemplate($sourceTemplate);

        $landingPage = $this->landingPageFactory->newLandingPage($langingPageId);
        $landingPage->create($name);
        $landingPage->changeTemplate($landingTemplateId);

        $this->collection[$langingPageId] = $langingPageId;

        $this->events->record(new LandingPageAddedToUserLandingPages(
            $langingPageId,
            $this->userId
        ));
    }
}
