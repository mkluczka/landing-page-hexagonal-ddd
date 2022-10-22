<?php

declare(strict_types=1);

namespace Tests\Unit\Application;

use LandingPage\Application\CreateLandingPageHandler;
use LandingPage\Domain\Exception\LandingPageException;
use LandingPage\Domain\LandingPage\LandingPagesRepository;
use LandingPage\Domain\LandingPage\UserLandingPages;
use LandingPage\Domain\SourceTemplate\SourceTemplate;
use LandingPage\Domain\SourceTemplate\SourceTemplatesRepository;
use LandingPage\Ports\Command\CreateLandingPage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateLandingPageHandlerTest extends TestCase
{
    private CreateLandingPageHandler $sut;
    private LandingPagesRepository&MockObject $landingPagesRepositoryMock;
    private SourceTemplatesRepository&MockObject $sourceTemplateRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new CreateLandingPageHandler(
            $this->landingPagesRepositoryMock = $this->createMock(LandingPagesRepository::class),
            $this->sourceTemplateRepositoryMock = $this->createMock(SourceTemplatesRepository::class),
        );
    }

    /**
     * @test
     */
    public function shouldCreateLandingPage(): void
    {
        $landingPageId = 'f8aaf146-a1cc-4377-bf53-2f6ba50d4dab';
        $sourceTemplateId = '9845a92e-9f25-4f1d-9cc0-7ae627704dc1';
        $landingName = 'Landing page name';
        $userId = '26ccd0b3-0418-4e35-bce8-8c77bab8d602';

        $this->sourceTemplateRepositoryMock
            ->expects(self::once())
            ->method('getById')
            ->with($sourceTemplateId)
            ->willReturn($sourceTemplate = $this->createMock(SourceTemplate::class));

        $this->landingPagesRepositoryMock
            ->expects(self::once())
            ->method('getCollection')
            ->with($userId)
            ->willReturn(
                $landingPageCollectionMock = $this->createMock(UserLandingPages::class)
            );

        $landingPageCollectionMock
            ->expects(self::once())
            ->method('addLandingPage')
            ->with($landingPageId, $sourceTemplate, $landingName);

        $this->sut->handle(new CreateLandingPage($landingPageId, $sourceTemplateId, $landingName, $userId));
    }

    /**
     * @test
     */
    public function shouldFailAddingLandingPageWithoutSourceTemplate(): void
    {
        $landingPageId = 'f8aaf146-a1cc-4377-bf53-2f6ba50d4dab';
        $sourceTemplateId = '9845a92e-9f25-4f1d-9cc0-7ae627704dc1';
        $landingName = 'Landing page name';
        $userId = 'ca9dee5a-ed94-404e-9702-96ae5b7afc20';

        $this->sourceTemplateRepositoryMock
            ->expects(self::once())
            ->method('getById')
            ->with($sourceTemplateId)
            ->willReturn(null);

        $this->expectException(LandingPageException::class);
        $this->expectExceptionCode(LandingPageException::SOURCE_TEMPLATE_NOT_FOUND);

        $this->sut->handle(new CreateLandingPage($landingPageId, $sourceTemplateId, $landingName, $userId));
    }
}
