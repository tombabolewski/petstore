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
}
