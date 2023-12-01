<?php

namespace App\Http\Controllers;

use App\Enums\PetStatus;
use Illuminate\Http\JsonResponse;

class PetStatusController extends Controller
{
    /**
     * Index PetStatuses
     *
     * Get all available statuses
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => PetStatus::all()]);
    }
}
