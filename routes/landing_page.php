<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Validator\GenericValidator;

Route::pattern('pageId', (new GenericValidator())->getPattern());

