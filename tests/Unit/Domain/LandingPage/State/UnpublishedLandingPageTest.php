<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\LandingPage\State;

use LandingPage\Domain\Events;
use LandingPage\Domain\Exception\LandingPageException;
use LandingPage\Domain\LandingPage\Event\LandingPagePublished;
use LandingPage\Domain\LandingPage\Event\LandingPageTemplateChanged;
use LandingPage\Domain\LandingPage\State\LandingPageStateFactory;
use LandingPage\Domain\LandingPage\State\UnpublishedLandingPage;
use LandingPage\Domain\Name;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class UnpublishedLandingPageTest extends TestCase
{
    private const ID = '8e767528-0a46-474f-89c8-c03b6c885702';
    private const TEMPLATE_ID = 'e2dbadd3-977f-4578-854b-d5f8fd6feb9f';
    private const ORIGINAL_NAME = 'aaaa';

    private UnpublishedLandingPage $sut;
    private Events&MockObject $eventsMock;
    private LandingPageStateFactory&MockObject $stateFactoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new UnpublishedLandingPage(
            self::ID,
            self::TEMPLATE_ID,
            new Name(self::ORIGINAL_NAME),
            $this->eventsMock = $this->createMock(Events::class),
            $this->stateFactoryMock = $this->createMock(LandingPageStateFactory::class),
        );
    }

    /**
     * @test
     */
    public function shouldChangeTemplate(): void
    {
        $newTemplateId = 'df2a3322-3e63-4024-846e-208b3be9bbc2';

        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPageTemplateChanged::class));

        $this->stateFactoryMock
            ->expects(self::once())
            ->method('stateUnpublished')
            ->with(self::ID, $newTemplateId, new Name(self::ORIGINAL_NAME));

        $this->sut->changeTemplate($newTemplateId);
    }

    /**
     * @test
     */
    public function shouldPublish(): void
    {
        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPagePublished::class));

        $this->stateFactoryMock
            ->expects(self::once())
            ->method('statePublished')
            ->with(self::ID);

        $this->sut->publish();
    }

    /**
     * @test
     */
    public function shouldFailCreate(): void
    {
        $this->eventsMock->expects(self::never())->method(self::anything());
        $this->stateFactoryMock->expects(self::never())->method(self::anything());

        $this->expectException(LandingPageException::class);
        $this->expectExceptionCode(LandingPageException::ACTION_NOT_ALLOWED_FOR_STATE);

        $this->sut->create('aa1');
    }
}
