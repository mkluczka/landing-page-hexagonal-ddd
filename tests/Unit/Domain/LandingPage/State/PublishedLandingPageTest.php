<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\LandingPage\State;

use LandingPage\Domain\Events;
use LandingPage\Domain\Exception\LandingPageException;
use LandingPage\Domain\LandingPage\Event\LandingPageRepublished;
use LandingPage\Domain\LandingPage\State\LandingPageStateFactory;
use LandingPage\Domain\LandingPage\State\PublishedLandingPage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class PublishedLandingPageTest extends TestCase
{
    private const ID = '8e767528-0a46-474f-89c8-c03b6c885702';

    private PublishedLandingPage $sut;
    private Events&MockObject $eventsMock;
    private LandingPageStateFactory&MockObject $stateFactoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new PublishedLandingPage(
            self::ID,
            $this->eventsMock = $this->createMock(Events::class),
            $this->stateFactoryMock = $this->createMock(LandingPageStateFactory::class),
        );
    }

    /**
     * @test
     */
    public function shouldPublish(): void
    {
        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPageRepublished::class));

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

    /**
     * @test
     */
    public function shouldFailChangeTemplate(): void
    {
        $this->eventsMock->expects(self::never())->method(self::anything());
        $this->stateFactoryMock->expects(self::never())->method(self::anything());

        $this->expectException(LandingPageException::class);
        $this->expectExceptionCode(LandingPageException::ACTION_NOT_ALLOWED_FOR_STATE);

        $this->sut->changeTemplate('9223c012-4ae9-4071-a649-77edd55b442a');
    }
}
