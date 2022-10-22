<?php

declare(strict_types=1);

namespace LandingPage\Ports\Command;

final class PublishLandingPage
{
    public function __construct(public readonly string $landingPageId)
    {
    }
}
