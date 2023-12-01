<?php

namespace App\Services\PetstoreApi;

use App\Enums\PetStatus;
use App\Services\PetstoreApi\Exceptions\InvalidIdException;
use App\Services\PetstoreApi\Exceptions\InvalidInputException;
use App\Services\PetstoreApi\Exceptions\InvalidStatusValueException;
use App\Services\PetstoreApi\Exceptions\PetNotFoundException;
use App\Services\PetstoreApi\Exceptions\UnknownApiErrorException;
use App\Services\PetstoreApi\Exceptions\ValidationFailedException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpFoundation\File\File;

class PetService
{
    public function __construct(
        private PendingRequest $client,
        private PetNormalizerService $petNormalizerService,
    ) {
    }

    public function index(array $statuses = []): array
    {
        if (empty($statuses)) {
            $statuses = PetStatus::all();
        }
        try {
            return $this->client->get('/pet/findByStatus', [
                'status' => implode(',', $statuses),
                ])
                ->throw()
                ->json();
        } catch (RequestException $e) {
            throw match ($e->response->status()) {
                400 => new InvalidStatusValueException($e),
                default => new UnknownApiErrorException($e),
            };
        }
    }

    public function get(int $id): array
    {
        $path = sprintf('/pet/%s', $id);
        try {
            return $this->client->get($path)->throw()->json();
        } catch (RequestException $e) {
            throw match ($e->response->status()) {
                400 => new InvalidIdException($e),
                404 => new PetNotFoundException($e),
                default => new UnknownApiErrorException($e),
            };
        }
    }

    public function post(array $payload): array
    {
        $payload = $this->petNormalizerService->normalize($payload);
        try {
            return $this->client->post('/pet', $payload)->throw()->json();
        } catch (RequestException $e) {
            throw match ($e->response->status()) {
                405 => new InvalidInputException($e),
                default => new UnknownApiErrorException($e),
            };
        }
    }

    public function uploadImage(int $id, File $file, string $additionalMetadata = ''): array
    {
        $path = sprintf('/pet/%s/uploadImage', $id);
        $filename = sprintf('%s.%s', time(), $file->guessExtension());
        return $this->client->attach('file', $file->getContent(), $filename)
        ->post($path, [
            [
                'name' => 'additionalMetadata',
                'contents' => $additionalMetadata,
            ],
        ])
        ->throw()
        ->json();
    }

    public function put(int $id, array $payload): array
    {
        $payload = $this->petNormalizerService->normalize($payload, $id);
        try {
            return $this->client->put('/pet', $payload)->throw()->json();
        } catch (RequestException $e) {
            throw match ($e->response->status()) {
                400 => new InvalidIdException($e),
                404 => new PetNotFoundException($e),
                405 => new ValidationFailedException($e),
                default => new UnknownApiErrorException($e),
            };
        }
    }

    public function delete(int $id): array
    {
        $path = sprintf('/pet/%s', $id);
        try {
            return $this->client->delete($path)->throw()->json();
        } catch (RequestException $e) {
            throw match ($e->response->status()) {
                400 => new InvalidIdException($e),
                404 => new PetNotFoundException($e),
                default => new UnknownApiErrorException($e),
            };
        }
    }
}
