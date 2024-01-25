<?php

namespace App\Services\PetstoreApi;

use App\Enums\PetStatus;

class PetNormalizerService
{
    public function normalize(array $payload, int|null $id = null): array
    {
        $normalized = [];
        if ($id) {
            $normalized['id'] = $id;
        }
        $normalized['status'] = $payload['status'] ?? PetStatus::Available->value;
        $normalized['name'] = $payload['name'] ?? '';
        $normalized['photoUrls'] = $payload['photoUrls'] ?? [];
        $normalized['tags'] = $payload['tags'] ?? [];
        $normalized['category'] = isset($payload['category']) ? ['name' => $payload['category']] : [];
        return $normalized;
    }
}
