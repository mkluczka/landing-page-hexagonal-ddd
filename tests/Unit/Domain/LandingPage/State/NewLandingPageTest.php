<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\LandingPage\State;

use LandingPage\Domain\Events;
use LandingPage\Domain\Exception\LandingPageException;
use LandingPage\Domain\LandingPage\Event\LandingPageCreated;
use LandingPage\Domain\LandingPage\State\LandingPageStateFactory;
use LandingPage\Domain\LandingPage\State\NewLandingPage;
use LandingPage\Domain\Name;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class NewLandingPageTest extends TestCase
{
    private const ID = '8e767528-0a46-474f-89c8-c03b6c885702';

    private NewLandingPage $sut;
    private Events&MockObject $eventsMock;
    private LandingPageStateFactory&MockObject $stateFactoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new NewLandingPage(
            self::ID,
            $this->eventsMock = $this->createMock(Events::class),
            $this->stateFactoryMock = $this->createMock(LandingPageStateFactory::class),
        );
    }

    /**
     * @test
     */
    public function shouldCreate(): void
    {
        $name = 'abcd';
        $expectedNameVO = new Name('abcd');

        $this->eventsMock
            ->expects(self::once())
            ->method('record')
            ->with(self::isInstanceOf(LandingPageCreated::class));

        $this->stateFactoryMock
            ->expects(self::once())
            ->method('stateUnpublished')
            ->with(self::ID, null, $expectedNameVO);

        $this->sut->create($name);
    }

    /**
     * @test
     */
    public function shouldFailChangeTemplate(): void
    {
        $this->expectException(LandingPageException::class);
        $this->expectExceptionCode(LandingPageException::ACTION_NOT_ALLOWED_FOR_STATE);

        $this->sut->changeTemplate('e46205a3-379b-4360-b8c8-3b763cd0a425');
    }

    /**
     * @test
     */
    public function shouldFailPublish(): void
    {
        $this->eventsMock->expects(self::never())->method(self::anything());
        $this->stateFactoryMock->expects(self::never())->method(self::anything());

        $this->expectException(LandingPageException::class);
        $this->expectExceptionCode(LandingPageException::ACTION_NOT_ALLOWED_FOR_STATE);

        $this->sut->publish();
    }
}
