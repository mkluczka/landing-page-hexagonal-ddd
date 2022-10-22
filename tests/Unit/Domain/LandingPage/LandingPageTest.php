<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\LandingPage;

use LandingPage\Domain\Events;
use LandingPage\Domain\LandingPage\Event\LandingPageCreated;
use LandingPage\Domain\LandingPage\Event\LandingPagePublished;
use LandingPage\Domain\LandingPage\Event\LandingPageRepublished;
use LandingPage\Domain\LandingPage\Event\LandingPageTemplateChanged;
use LandingPage\Domain\LandingPage\LandingPage;
use LandingPage\Domain\PublicationStatus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LandingPageTest extends TestCase
{
    private Events&MockObject $eventsMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventsMock = $this->createMock(Events::class);
    }

    /**
     * @test
     */
    public function shouldCreate(): void
    {
        $landingName = 'Landing name';

        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPageCreated::class));

        $landingPage = new LandingPage(
            '806d28bd-9f1b-458f-92e4-9a532ab0b145',
            PublicationStatus::UNPUBLISHED,
            $this->eventsMock
        );
        $landingPage->create($landingName);
    }

    /**
     * @test
     */
    public function shouldChangeTemplate(): void
    {
        $landingTemplateId = 'f1e4d8cc-739d-4c94-9dbd-40267a8d25e4';

        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPageTemplateChanged::class));

        $landingPage = new LandingPage(
            '806d28bd-9f1b-458f-92e4-9a532ab0b145',
            PublicationStatus::UNPUBLISHED,
            $this->eventsMock
        );
        $landingPage->changeTemplate($landingTemplateId);
    }

    /**
     * @test
     */
    public function shouldPublish(): void
    {
        $landingPageId = '806d28bd-9f1b-458f-92e4-9a532ab0b145';

        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPagePublished::class));

        $landingPage = new LandingPage(
            $landingPageId,
            PublicationStatus::UNPUBLISHED,
            $this->eventsMock
        );
        $landingPage->publish();
    }

    /**
     * @test
     */
    public function shouldRepublish(): void
    {
        $landingPageId = '806d28bd-9f1b-458f-92e4-9a532ab0b145';

        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPageRepublished::class));

        $landingPage = new LandingPage(
            $landingPageId,
            PublicationStatus::PUBLISHED,
            $this->eventsMock
        );
        $landingPage->publish();
    }
}
