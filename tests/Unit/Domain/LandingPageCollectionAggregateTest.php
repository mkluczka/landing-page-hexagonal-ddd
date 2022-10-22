<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use LandingPage\Domain\Events;
use LandingPage\Domain\Exception\LandingPageException;
use LandingPage\Domain\LandingPage\Event\LandingPageAddedToUserLandingPages;
use LandingPage\Domain\LandingPage\LandingPage;
use LandingPage\Domain\LandingPage\LandingPageCollection;
use LandingPage\Domain\LandingPage\LandingPageFactory;
use LandingPage\Domain\LandingPage\Template\LandingTemplate;
use LandingPage\Domain\LandingPage\Template\LandingTemplateFactory;
use LandingPage\Domain\SourceTemplate\SourceTemplate;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LandingPageCollectionAggregateTest extends TestCase
{
    private LandingPageFactory&MockObject $landingPageFactoryMock;
    private LandingTemplateFactory&MockObject $landingTemplateFactoryMock;
    private Events&MockObject $eventsMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->landingPageFactoryMock = $this->createMock(LandingPageFactory::class);
        $this->landingTemplateFactoryMock = $this->createMock(LandingTemplateFactory::class);
        $this->eventsMock = $this->createMock(Events::class);
    }

    /**
     * @test
     */
    public function shouldFailAddingAlreadyExistingLandingPage(): void
    {
        $sourceTemplateMock = $this->createMock(SourceTemplate::class);

        $landingPageId = 'e2a17860-8ed3-4fac-995d-fc91cccf02de';

        $this->expectException(LandingPageException::class);
        $this->expectExceptionCode(LandingPageException::LANDING_PAGE_ID_IS_ALREADY_USED);


        $sut = new LandingPageCollection(
            '6ae0ad81-6afa-423e-b982-a49405b385e4',
            [$landingPageId => $this->createStub(LandingPage::class)],
            $this->landingPageFactoryMock,
            $this->landingTemplateFactoryMock,
            $this->eventsMock,
        );
        $sut->addLandingPage($landingPageId, $sourceTemplateMock, 'landing name');
    }

    /**
     * @test
     */
    public function shouldFailAddingSameSiteTwice(): void
    {
        $userId = '40c2b39b-a1f4-434c-9024-79020b46fca9';
        $landingPageId = 'e221d847-d7d6-43c1-87a1-0eae8f2108f1';
        $sourceTemplateStub = $this->createStub(SourceTemplate::class);
        $landingName = 'Landing name';

        $this->expectException(LandingPageException::class);
        $this->expectExceptionCode(LandingPageException::LANDING_PAGE_ID_IS_ALREADY_USED);

        $sut = new LandingPageCollection(
            $userId,
            [],
            $this->landingPageFactoryMock,
            $this->landingTemplateFactoryMock,
            $this->eventsMock,
        );
        $sut->addLandingPage($landingPageId, $sourceTemplateStub, $landingName);
        $sut->addLandingPage($landingPageId, $sourceTemplateStub, $landingName);
    }

    /**
     * @test
     */
    public function shouldAddLandingPageToUserLandingPages(): void
    {
        $userId = '40c2b39b-a1f4-434c-9024-79020b46fca9';
        $landingPageId = 'e221d847-d7d6-43c1-87a1-0eae8f2108f1';
        $landingTemplateId = '92210d38-6667-4b66-b7c6-1f699d4b2063';
        $sourceTemplateStub = $this->createStub(SourceTemplate::class);
        $landingName = 'Landing name';

        $this->landingTemplateFactoryMock
            ->expects(self::once())
            ->method('newLandingTemplate')
            ->willReturn($landingTemplateMock = $this->createMock(LandingTemplate::class));

        $landingTemplateMock
            ->expects(self::once())
            ->method('createFromSourceTemplate')
            ->with($sourceTemplateStub)
            ->willReturn($landingTemplateId);

        $this->landingPageFactoryMock
            ->expects(self::once())
            ->method('newLandingPage')
            ->with($landingPageId)
            ->willReturn($landingPageMock = $this->createMock(LandingPage::class));

        $landingPageMock
            ->expects(self::once())
            ->method('create')
            ->with($landingName);

        $landingPageMock
            ->expects(self::once())
            ->method('changeTemplate')
            ->with($landingTemplateId);

        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPageAddedToUserLandingPages::class));

        $sut = new LandingPageCollection(
            $userId,
            [],
            $this->landingPageFactoryMock,
            $this->landingTemplateFactoryMock,
            $this->eventsMock,
        );
        $sut->addLandingPage($landingPageId, $sourceTemplateStub, $landingName);
    }
}
