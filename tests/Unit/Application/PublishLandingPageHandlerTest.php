<?php

declare(strict_types=1);

namespace Tests\Unit\Application;

use LandingPage\Application\PublishLandingPageHandler;
use LandingPage\Domain\LandingPage\LandingPage;
use LandingPage\Domain\LandingPage\LandingPagesRepository;
use LandingPage\Ports\Command\PublishLandingPage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class PublishLandingPageHandlerTest extends TestCase
{
    private PublishLandingPageHandler $sut;
    private LandingPagesRepository&MockObject $landingPagesRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new PublishLandingPageHandler(
            $this->landingPagesRepositoryMock = $this->createMock(LandingPagesRepository::class),
        );
    }

    /**
     * @test
     */
    public function shouldPublishLandingPage(): void
    {
        $landingPageId = '33fb189a-8abd-4824-8068-c1a650a885df';

        $this->landingPagesRepositoryMock
            ->expects(self::once())
            ->method('getOne')
            ->with($landingPageId)
            ->willReturn($landingPageMock = $this->createMock(LandingPage::class));

        $landingPageMock
            ->expects(self::once())
            ->method('publish');

        $command = new PublishLandingPage($landingPageId);
        $this->sut->handle($command);
    }
}
