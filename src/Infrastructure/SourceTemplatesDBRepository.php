<?php

declare(strict_types=1);

namespace LandingPage\Infrastructure;

use LandingPage\Domain\SourceTemplate\SourceTemplate;
use LandingPage\Domain\SourceTemplate\SourceTemplatesRepository;

final class SourceTemplatesDBRepository implements SourceTemplatesRepository
{
    public function getById(string $sourceTemplateId): ?SourceTemplate
    {
        return new SourceTemplate();
    }
}
