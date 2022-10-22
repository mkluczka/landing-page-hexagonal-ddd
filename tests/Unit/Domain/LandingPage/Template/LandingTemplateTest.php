<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\LandingPage\Template;

use LandingPage\Domain\Events;
use LandingPage\Domain\LandingPage\Template\LandingTemplate;
use LandingPage\Domain\SourceTemplate\SourceTemplate;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LandingTemplateTest extends TestCase
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
    public function shouldCreateFromSourceTemplate(): void
    {
        $sut = new LandingTemplate(
            $landingTemplateId = 'a5c30391-d321-48e4-9051-c6a9e5a245f2',
            $this->eventsMock,
        );

        self::assertEquals(
            $landingTemplateId,
            $sut->createFromSourceTemplate($this->createMock(SourceTemplate::class)),
        );
    }
}
