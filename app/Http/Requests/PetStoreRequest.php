<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required',
            'category_name' => 'required|string',
            'name' => 'required|string',
            'tags' => 'nullable|array',
            'tags.id' => 'nullable',
            'tags.name' => 'nullable|string',
            'photo_urls' => 'nullable|array',
            'photo_urls.*' => 'nullable|url',
            'status' => 'required|string',
        ];
    }
}
