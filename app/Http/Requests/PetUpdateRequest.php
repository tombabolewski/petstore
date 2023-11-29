<?php

namespace App\Http\Requests;

use App\Enums\PetStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'integer|required',
            'category' => 'array',
            'category.id' => 'integer',
            'category.name' => 'string|nullable',
            'name' => 'string|nullable',
            'photoUrls' => 'array',
            'photoUrls.*' => 'string',
            'tags' => 'array',
            'tags.*' => 'array',
            'tags.*.id' => 'integer',
            'tags.*.name' => 'string|nullable',
            'status' => ['string', Rule::in(PetStatus::all())],
        ];
    }
}
