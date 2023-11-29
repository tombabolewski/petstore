<?php

namespace App\Services\PetstoreApi;

use App\Enums\PetStatus;
use Illuminate\Http\Client\PendingRequest;
use Symfony\Component\HttpFoundation\File\File;

class PetService
{
    public function __construct(private PendingRequest $client)
    {
    }

    public function index(array $statuses = []): array
    {
        if (empty($statuses)) {
            $statuses = PetStatus::all();
        }
        return $this->client->get('/pet/findByStatus', [
            'status' => implode(',', $statuses),
        ])
        ->throw()
        ->json();
    }

    public function get(int $id): array
    {
        $path = sprintf('/pet/%s', $id);
        return $this->client->get($path)->throw()->json();
    }

    public function post(array $payload): bool
    {
        return $this->client->post('/pet', $payload)->throw()->successful();
    }

    public function uploadImage(int $id, File $file, array $additionalMetadata = []): bool
    {
        $path = sprintf('/pet/%s/uploadImage');
        return $this->client->attach('file', $file->getContent())
        ->post($path, [
            'additionalMetadata' => $additionalMetadata,
        ])
        ->throw()
        ->successful();
    }

    public function put(int $id, array $payload): bool
    {
        $path = sprintf('/pet/%s', $id);
        return $this->client->put($path, $payload)->throw()->successful();
    }

    public function delete(int $id): bool
    {
        $path = sprintf('/pet/%s', $id);
        return $this->client->delete($path)->throw()->successful();
    }
}
