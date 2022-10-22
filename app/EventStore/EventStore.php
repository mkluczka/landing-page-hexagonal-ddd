<?php

declare(strict_types=1);

namespace App\EventStore;

use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

final class EventStore
{
    private $file;

    public function __construct(private readonly string $fileStorePath)
    {
        $this->file = fopen($this->fileStorePath, 'w');
    }

    public function record(string $eventName, array $payload): void
    {
        DB::table('event_store')->insert([
            'id' => Uuid::uuid4()->toString(),
            'event_name' => $eventName,
            'payload' => json_encode($payload),
            'created_at' => new \DateTimeImmutable(),
        ]);

        fputcsv(
            $this->file,
            [
                'id' => Uuid::uuid4()->toString(),
                'event_name' => $eventName,
                'payload' => json_encode($payload),
                'created_at' => date(DateTimeInterface::ATOM),
            ]
        );
    }
}
