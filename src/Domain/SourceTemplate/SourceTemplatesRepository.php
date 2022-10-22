<?php

declare(strict_types=1);

namespace LandingPage\Domain\SourceTemplate;

use JeroenG\Autowire\Attribute\Autowire;

#[Autowire]
interface SourceTemplatesRepository
{
    public function getById(string $sourceTemplateId): ?SourceTemplate;
}
