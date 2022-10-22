<?php

declare(strict_types=1);

namespace LandingPage\Domain\LandingPage;

use JeroenG\Autowire\Attribute\Autowire;

#[Autowire]
interface LandingPagesRepository
{
    public function getCollection(string $userId): LandingPageCollection;

    public function getOne(string $landingPageId): LandingPage;
}
