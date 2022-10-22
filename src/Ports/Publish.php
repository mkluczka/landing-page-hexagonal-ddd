<?php

declare(strict_types=1);

namespace LandingPage\Ports;

interface Publish
{
    public function __invoke(string $landingPageId): void;
}
