<?php

namespace App\Http\Requests;

use App\Enums\PetStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'array',
            'status.*' => [Rule::enum(PetStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'status' => [
                'description' => 'Array of Pet statuses to filter by',
                'example' => '["available", "pending"]',
            ],
            'status.*' => [
                'description' => 'Pet status in the store',
                'example' => 'available',
            ],
        ];
    }
}
