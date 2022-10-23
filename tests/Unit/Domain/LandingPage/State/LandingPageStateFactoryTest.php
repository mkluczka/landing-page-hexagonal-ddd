<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\LandingPage\State;

use LandingPage\Domain\Events;
use LandingPage\Domain\LandingPage\State\LandingPageStateFactory;
use LandingPage\Domain\LandingPage\State\NewLandingPage;
use LandingPage\Domain\LandingPage\State\PublishedLandingPage;
use LandingPage\Domain\LandingPage\State\UnpublishedLandingPage;
use LandingPage\Domain\Name;
use PHPUnit\Framework\TestCase;

final class LandingPageStateFactoryTest extends TestCase
{
    private const ID = '6137abe3-a82c-4b1a-9378-556707b81c65';

    private LandingPageStateFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new LandingPageStateFactory($this->createStub(Events::class));
    }

    /**
     * @test
     */
    public function shouldCreateStateNew(): void
    {
        self::assertInstanceOf(
            NewLandingPage::class,
            $this->sut->stateNew(self::ID)
        );
    }

    /**
     * @test
     */
    public function shouldCreateStateUnpublished(): void
    {
        self::assertInstanceOf(
            UnpublishedLandingPage::class,
            $this->sut->stateUnpublished(self::ID, null, new Name('abcd'))
        );
    }

    /**
     * @test
     */
    public function shouldCreateStatePublished(): void
    {
        self::assertInstanceOf(
            PublishedLandingPage::class,
            $this->sut->statePublished(self::ID)
        );
    }

}
