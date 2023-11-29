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
            'category' => 'array',
            'category.id' => 'integer',
            'category.name' => 'string',
            'name' => 'string',
            'photoUrls' => 'array',
            'photoUrls.*' => 'string',
            'tags' => 'array',
            'tags.*' => 'array',
            'tags.*.id' => 'integer',
            'tags.*.name' => 'string',
            'status' => ['string', Rule::in(PetStatus::all())],
        ];
    }
}
