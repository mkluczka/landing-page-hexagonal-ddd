<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use RefreshDatabase;

    public function createApplication()
    {
        $this->app = require __DIR__ . '/../bootstrap/app.php';

        $this->app->make(Kernel::class)->bootstrap();

        return $this->app;
    }

    protected function fakeUuidFactory(array $ids): void
    {
        Uuid::setFactory(new class($ids) extends UuidFactory {

            public function __construct(private array $ids)
            {
                parent::__construct();
            }

            public function uuid4(): UuidInterface
            {
                return Uuid::fromString(array_shift($this->ids) ?? parent::uuid4()->toString());
            }
        });
    }
}
