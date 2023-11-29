<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetIndexRequest;
use App\Http\Requests\PetStoreRequest;
use App\Http\Requests\PetUpdateRequest;
use App\Http\Requests\PetUploadImageRequest;
use App\Services\PetstoreApi\PetService;
use Illuminate\Http\JsonResponse;

class PetController extends Controller
{
    public function __construct(private PetService $petService)
    {
    }

    /**
     * Display all pets, optionally filtered by status
     */
    public function index(PetIndexRequest $request): JsonResponse
    {
        /** @var array $statuses */
        $statuses = $request->validated('status') ?? [];
        $pets = $this->petService->index($statuses);
        return response()->json(['data' => $pets]);
    }

    /**
     * Store a new pet
     */
    public function store(PetStoreRequest $request): JsonResponse
    {
        $payload = $request->validated();
        $this->petService->post($payload);
        return response()->json(['message' => 'Pet created successfully'], 201);
    }

    /**
     * Upload an image for a specific pet
     */
    public function uploadImage(PetUploadImageRequest $request, int $id): JsonResponse
    {
        $file = $request->file('file');
        $this->petService->uploadImage($id, $file);
        return response()->json(['message' => 'Image uploaded successfully']);
    }

    /**
     * Display the information about a specific pet
     */
    public function show(int $id)
    {
        $pet = $this->petService->get($id);
        return response()->json(['data' => $pet]);
    }

    /**
     * Update a specific pet
     */
    public function update(PetUpdateRequest $request, int $id)
    {
        $payload = $request->validated();
        $this->petService->put($id, $payload);
        return response()->json(['message' => 'Pet updated successfully']);
    }

    /**
     * Remove a specific pet
     */
    public function destroy(int $id)
    {
        $this->petService->delete($id);
        return response()->json(['message' => 'Pet deleted successfully']);
    }
}
