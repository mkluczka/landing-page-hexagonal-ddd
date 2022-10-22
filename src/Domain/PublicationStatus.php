<?php

declare(strict_types=1);

namespace LandingPage\Domain;

enum PublicationStatus
{
    case PUBLISHED;
    case UNPUBLISHED;
}
