<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\LandingPage;

use LandingPage\Domain\LandingPage\LandingPage;
use LandingPage\Domain\LandingPage\State\LandingPageState;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LandingPageTest extends TestCase
{
    private LandingPage $sut;
    private LandingPageState&MockObject $stateMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new LandingPage(
            $this->stateMock = $this->createMock(LandingPageState::class),
        );
    }

    /**
     * @test
     */
    public function shouldCreate(): void
    {
        $name = 'abc';

        $this->stateMock
            ->expects(self::once())
            ->method('create')
            ->with($name);

        $this->sut->create($name);
    }

    /**
     * @test
     */
    public function shouldChangeTemplate(): void
    {
        $landingTemplateId = '457c349e-b711-4887-8ff6-2debaddcf2bc';

        $this->stateMock
            ->expects(self::once())
            ->method('changeTemplate')
            ->with($landingTemplateId);

        $this->sut->changeTemplate($landingTemplateId);
    }

    /**
     * @test
     */
    public function shouldPublish(): void
    {
        $this->stateMock
            ->expects(self::once())
            ->method('publish');

        $this->sut->publish();
    }
}
