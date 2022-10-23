<?php

declare(strict_types=1);

namespace Tests\Integration;

use JildertMiedema\LaravelTactician\DispatchesCommands;
use LandingPage\Application\CreateLandingPageHandler;
use LandingPage\Ports\Command\CreateLandingPage;
use Tests\TestCase;

final class CreateLandingPageHandlerTest extends TestCase
{
    use CreateLandingPageDataProvider;
    use DispatchesCommands;

    private CreateLandingPageHandler $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = $this->app->get(CreateLandingPageHandler::class);
    }

    /**
     * @test
     */
    public function shouldCreateLandingPage(): void
    {
        $transactionId = '80160abd-eae7-4e5d-8e0f-a0a0012e920d';
        $landingTemplateId = 'dd92d0f2-dfc1-4a48-922a-da0462fe0712';

        $landingPageId = 'd42f72cf-1763-46ca-8d1b-9faffb67fba6';
        $sourceTemplateId = 'c6f64b13-302f-46d0-bac3-183dc7d9c442';
        $landingName = 'Landing name';
        $userId = 'a54379da-f62d-4f84-a2bf-af72e41ed044';

        $this->fakeUuidFactory([$transactionId, null, null, $landingTemplateId]);

        $command = new CreateLandingPage($landingPageId, $sourceTemplateId, $landingName, $userId);
        $this->dispatch($command);

        $expectedEvents = $this->createdLandingPageExpectedEvents($transactionId, $landingTemplateId, $landingPageId, $userId);
        foreach ($expectedEvents as $event) {
            $this->assertDatabaseHas('event_store', $event);
        }
    }
}
