<?php

namespace App\Http\Requests;

use App\Enums\PetStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => 'string|nullable',
            'name' => 'string|nullable',
            'photoUrls' => 'array',
            'photoUrls.*' => 'string|nullable',
            'tags' => 'array',
            'tags.*' => 'string|nullable',
            'status' => ['string', Rule::in(PetStatus::all())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'category' => [
                'description' => 'Category name',
                'example' => 'Mammal',
            ],
            'name' => [
                'description' => 'Pet name',
                'example' => 'Doggie',
            ],
            'photoUrls' => [
                'description' => 'List of photo URLs',
                'example' => '["https://www.example.com/doggie.jpg"]',
            ],
            'photoUrls.*' => [
                'description' => 'Photo URL',
                'example' => 'https://www.example.com/doggie.jpg',
            ],
            'tags' => [
                'description' => 'List of tags',
                'example' => '["foo", "bar"]',
            ],
            'tags.*' => [
                'description' => 'Tag name',
                'example' => 'foo',
            ],
            'status' => [
                'description' => 'Pet status',
                'example' => 'available',
            ],
        ];
    }
}
