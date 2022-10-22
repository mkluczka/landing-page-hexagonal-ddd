<?php

declare(strict_types=1);

namespace LandingPage\Domain\Exception;

final class NameIsTooLongException extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct("Name `$name` is too long, max 64 characters are required");
    }
}
