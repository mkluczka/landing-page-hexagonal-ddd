<?php

declare(strict_types=1);

namespace LandingPage\Domain\Exception;

final class LandingPageException extends \Exception
{
    public const LANDING_PAGE_ID_IS_ALREADY_USED = 1;
    public const SOURCE_TEMPLATE_NOT_FOUND = 2;
    public const ACTION_NOT_ALLOWED_FOR_STATE = 3;

    public static function landingPageIdIsAlreadyUsed(string $landingPageId): self
    {
        return new self(
            "Landing page with id `$landingPageId` is already used",
            self::LANDING_PAGE_ID_IS_ALREADY_USED,
        );
    }

    public static function sourceTemplateNotFound(string $sourceTemplateId): self
    {
        return new self(
            "Source template `$sourceTemplateId` was not found",
            self::SOURCE_TEMPLATE_NOT_FOUND,
        );
    }

    public static function actionNotAllowedForState(string $action, string $stateInstance): self
    {
        return new self(
            "Action `$action` is not allowed for state `$stateInstance`",
            self::ACTION_NOT_ALLOWED_FOR_STATE,
        );
    }
}
