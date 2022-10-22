<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use LandingPage\Domain\Exception\NameIsTooLongException;
use LandingPage\Domain\Exception\NameIsTooShortException;
use LandingPage\Domain\Name;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFailWithTooShortError(): void
    {
        $this->expectException(NameIsTooShortException::class);

        new Name('a');
    }

    /**
     * @test
     */
    public function shouldFailWithTooLongError(): void
    {
        $this->expectException(NameIsTooLongException::class);

        new Name(str_repeat('a', 65));
    }
}
