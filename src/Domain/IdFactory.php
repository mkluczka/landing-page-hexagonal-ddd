<?php

declare(strict_types=1);

namespace LandingPage\Domain;

use JeroenG\Autowire\Attribute\Autowire;

#[Autowire]
interface IdFactory
{
    public function generateId(): string;
}
