<?php

declare(strict_types=1);

namespace App\Providers;

use App\EventStore\EventStore;
use App\EventStore\EventStoreTransactionMiddleware;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton(EventStore::class, fn() => new EventStore(
            base_path() . '/storage/event_store.csv',
        ));

        /** @var Collection $tactitianMiddlewares */
        $tactitianMiddlewares = $this->app->get('tactician.middleware');

        $tactitianMiddlewares->prepend('event_store_transaction');

        $this->app->bind('event_store_transaction', EventStoreTransactionMiddleware::class);
    }
}
