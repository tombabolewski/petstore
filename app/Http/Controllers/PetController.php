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
     * Index Pets
     *
     * Display all pets, optionally filtered by status
     *
     * @response 422 scenario="Invalid status value" {"message": "API returned an Invalid Status Value error. Please contact the administrator."}
     */
    public function index(PetIndexRequest $request): JsonResponse
    {
        /** @var array $statuses */
        $statuses = $request->validated('status') ?? [];
        $pets = $this->petService->index($statuses);
        return response()->json(['data' => $pets]);
    }

    /**
     * Store Pet
     *
     * Store a new pet
     *
     * @response 422 scenario="Invalid Input" {"message": "API returned an Invalid Input error. Please correct the provided data and try again."}
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
     * Upload Pet Image
     *
     * Upload an image for a specific pet
     *
     * @urlParam id int required The ID of the pet to upload an image for.
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
     * Show Pet
     *
     * Display the information about a specific pet
     *
     * @urlParam id int required The ID of the pet to retrieve.
     *
     * @response 422 scenario="Invalid ID" {"message": "API returned an Invalid ID error. Please contact the administrator."}
     * @response 404 scenario="Pet not found" {"message": "Pet not found."}
     */
    public function show(string $id): JsonResponse
    {
        $pet = $this->petService->get((int)$id);
        return response()->json(['data' => $pet]);
    }

    /**
     * Update Pet
     *
     * Update a specific pet.
     * Note: Full payload must be provided for both PUT and PATCH methods as they work exactly the same
     *
     * @urlParam id int required The ID of the pet to update.
     *
     * @response 404 scenario="Pet not found" {"message": "Pet not found."}
     * @response 422 scenario="Invalid ID" {"message": "API returned an Invalid ID error. Please contact the administrator."}
     * @response 422 scenario="Validation Error" {"message": "API returned a Validation error. Please correct your input and try again."}
     */
    public function update(PetUpdateRequest $request, string $id): JsonResponse
    {
        $payload = $request->validated();
        $pet = $this->petService->put((int)$id, $payload);
        return response()->json([
            'message' => 'Pet updated successfully',
            'data' => $pet,
        ]);
    }

    /**
     * Destroy Pet
     *
     * Remove a specific pet
     *
     * @urlParam id int required The ID of the pet to delete.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->petService->delete((int)$id);
        return response()->json(['message' => 'Pet deleted successfully']);
    }
}
