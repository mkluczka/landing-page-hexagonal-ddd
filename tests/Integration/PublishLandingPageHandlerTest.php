<?php

declare(strict_types=1);

namespace Tests\Integration;

use JildertMiedema\LaravelTactician\DispatchesCommands;
use LandingPage\Application\CreateLandingPageHandler;
use LandingPage\Infrastructure\LandingPagesFixedRepository;
use LandingPage\Ports\Command\PublishLandingPage;
use Tests\TestCase;

final class PublishLandingPageHandlerTest extends TestCase
{
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
    public function shouldPublishLandingPage(): void
    {
        $landingPageId = '65641af8-50cf-4968-b012-038596bbce2d';

        $command = new PublishLandingPage($landingPageId);
        $this->dispatch($command);

        $this->assertDatabaseHas('event_store', [
            'event_name' => 'landing_page_published',
            'payload' => json_encode(['id' => $landingPageId]),
            'order' => 1,
        ]);
    }

    /**
     * @test
     */
    public function shouldRepublishLandingPage(): void
    {
        $landingPageId = LandingPagesFixedRepository::PUBLISHED_LANDING_PAGE_ID;

        $command = new PublishLandingPage($landingPageId);
        $this->dispatch($command);

        $this->assertDatabaseHas('event_store', [
            'event_name' => 'landing_page_republished',
            'payload' => json_encode(['id' => $landingPageId]),
            'order' => 1,
        ]);
    }
}
