<?php

declare(strict_types=1);

namespace LandingPage\Domain\Exception;

final class NameIsTooShortException extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct("Name `$name` is too short, min. 3 characters are required");
    }
}
