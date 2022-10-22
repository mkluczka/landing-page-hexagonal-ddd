<?php

declare(strict_types=1);

namespace LandingPage\Domain;

use LandingPage\Domain\Exception\NameIsTooLongException;
use LandingPage\Domain\Exception\NameIsTooShortException;

final class Name
{
    public function __construct(public readonly string $value)
    {
        if (mb_strlen($value) < 3) {
            throw new NameIsTooShortException($this->value);
        }

        if (mb_strlen($value) > 64) {
            throw new NameIsTooLongException($this->value);
        }
    }
}
