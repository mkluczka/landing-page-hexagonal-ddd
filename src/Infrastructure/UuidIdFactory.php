<?php

declare(strict_types=1);

namespace LandingPage\Infrastructure;

use LandingPage\Domain\IdFactory;
use Ramsey\Uuid\Uuid;

final class UuidIdFactory implements IdFactory
{
    public function generateId(): string
    {
        return Uuid::uuid4()->toString();
    }
}
