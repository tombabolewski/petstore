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
        $pet = $this->petService->post($payload);
        return response()->json([
            'message' => 'Pet created successfully',
            'data' => $pet,
        ], 201);
    }

    /**
     * Upload an image for a specific pet
     */
    public function uploadImage(PetUploadImageRequest $request, string $id): JsonResponse
    {
        $file = $request->file('file');
        $data = $this->petService->uploadImage((int)$id, $file);
        return response()->json([
            'message' => 'Image uploaded successfully',
            'data' => $data,
        ]);
    }

    /**
     * Display the information about a specific pet
     */
    public function show(string $id): JsonResponse
    {
        $pet = $this->petService->get((int)$id);
        return response()->json(['data' => $pet]);
    }

    /**
     * Update a specific pet
     */
    public function update(PetUpdateRequest $request, string $id): JsonResponse
    {
        dd($request->all(), $request->validated());
        $payload = $request->validated();
        $pet = $this->petService->put((int)$id, $payload);
        return response()->json([
            'message' => 'Pet updated successfully',
            'data' => $pet,
        ]);
    }

    /**
     * Remove a specific pet
     */
    public function destroy(string $id): JsonResponse
    {
        $this->petService->delete((int)$id);
        return response()->json(['message' => 'Pet deleted successfully']);
    }
}
