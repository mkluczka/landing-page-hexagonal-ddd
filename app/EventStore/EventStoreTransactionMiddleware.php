<?php

declare(strict_types=1);

namespace App\EventStore;

use League\Tactician\Middleware;
use Ramsey\Uuid\Uuid;
use ReflectionObject;

final class EventStoreTransactionMiddleware implements Middleware
{
    public function __construct(private readonly EventStore $eventStore)
    {
    }

    public function execute($command, callable $next)
    {
        $reflection = new ReflectionObject($command);
        $runsInTransaction = $reflection->getAttributes(EventStoreTransaction::class) !== [];

        if ($runsInTransaction) {
            $transactionId = Uuid::uuid4()->toString();
            $this->eventStore->record('transaction_started', ['transactionId' => $transactionId]);

            try {
                $next($command);

                $this->eventStore->record('transaction_commited', ['transactionId' => $transactionId]);

                return;
            } catch (\Throwable $exception) {
                $this->eventStore->record('transaction_rollbacked', ['transactionId' => $transactionId]);

                throw $exception;
            }
        }

        $next($command);
    }
}
