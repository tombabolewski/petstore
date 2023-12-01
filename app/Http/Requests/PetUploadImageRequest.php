<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetUploadImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'file' => [
                'description' => 'Image file to upload, sent over multipart/form-data',
            ],
        ];
    }
}
