<?php

declare(strict_types=1);

namespace Tests\Integration\EventStore;

use App\EventStore\EventStoreTransaction;
use App\EventStore\EventStoreTransactionMiddleware;
use Tests\TestCase;

#[EventStoreTransaction]
final class TestCommand
{
}

final class EventStoreTransactionMiddlewareTest extends TestCase
{
    private EventStoreTransactionMiddleware $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = $this->app->get(EventStoreTransactionMiddleware::class);
    }

    /**
     * @test
     */
    public function shouldRunWithoutTransaction(): void
    {
        $this->sut->execute(new \stdClass(), fn() => null);

        $this->assertDatabaseCount('event_store', 0);
    }

    /**
     * @test
     */
    public function shouldCommitTransaction(): void
    {
        $this->fakeUuidFactory([
            $transactionId = '8fbf2b84-5bb9-4dc2-852e-dc4171442f63',
        ]);

        $this->sut->execute(new TestCommand(), fn() => null);

        $this->assertDatabaseHas(
            'event_store',
            [
                'event_name' => 'transaction_started',
                'payload' => json_encode(['transactionId' => $transactionId]),
                'order' => 1,
            ],
        );
        $this->assertDatabaseHas(
            'event_store',
            [
                'event_name' => 'transaction_commited',
                'payload' => json_encode(['transactionId' => $transactionId]),
                'order' => 2,
            ],
        );
    }

    /**
     * @test
     */
    public function shouldRollbackTransaction(): void
    {
        $this->fakeUuidFactory([
            $transactionId = '8fbf2b84-5bb9-4dc2-852e-dc4171442f63',
        ]);

        $this->expectException(\Exception::class);

        $this->sut->execute(new TestCommand(), fn() => throw new \Exception());

        $this->assertDatabaseHas(
            'event_store',
            [
                'event_name' => 'transaction_started',
                'payload' => json_encode(['transactionId' => $transactionId]),
                'order' => 1,
            ],
        );
        $this->assertDatabaseHas(
            'event_store',
            [
                'event_name' => 'transaction_rollbacked',
                'payload' => json_encode(['transactionId' => $transactionId]),
                'order' => 2,
            ],
        );
    }
}
