<?php

namespace App\Http\Controllers;

use App\Enums\PetStatus;
use Illuminate\Http\JsonResponse;

class PetStatusController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => PetStatus::all()]);
    }
}
