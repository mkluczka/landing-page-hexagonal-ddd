<?php

declare(strict_types=1);

namespace Tests\Integration;

trait CreateLandingPageDataProvider
{
    private function createdLandingPageExpectedEvents(string $transactionId, string $landingTemplateId, string $landingPageId, string $userId): array
    {
        return [
            [
                'event_name' => 'transaction_started',
                'payload' => json_encode(['transactionId' => $transactionId]),
                'order' => 1,
            ],
            [
                'event_name' => 'landing_template_created',
                'payload' => json_encode(['templateId' => $landingTemplateId]),
                'order' => 2,
            ],
            [
                'event_name' => 'landing_page_created',
                'payload' => json_encode(['id' => $landingPageId, 'name' => 'Landing name']),
                'order' => 3,
            ],
            [
                'event_name' => 'landing_page_template_changed',
                'payload' => json_encode(['id' => $landingPageId, 'templateId' => $landingTemplateId]),
                'order' => 4,
            ],
            [
                'event_name' => 'landing_page_added_to_user_landing_pages',
                'payload' => json_encode(['id' => $landingPageId, 'userId' => $userId]),
                'order' => 5,
            ],
            [
                'event_name' => 'transaction_commited',
                'payload' => json_encode(['transactionId' => $transactionId]),
                'order' => 6,
            ]
        ];
    }
}
