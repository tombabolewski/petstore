<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\PetStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('pet', PetController::class)->parameter('pet', 'id');
Route::post('pet/{id}/uploadImage', [PetController::class, 'uploadImage'])->name('pet.uploadImage');
Route::get('petStatus', [PetStatusController::class, 'index'])->name('petStatus.index');
