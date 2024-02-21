<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:5', 'max:50', 'unique:apartments'],
            'visibility' => ['required', 'boolean'],
            'services' => ['nullable', 'exists:services,id'],
            'num_rooms' => ['nullable', 'numeric', 'min:0', 'max:254'],
            'num_beds' => ['nullable', 'numeric', 'min:0', 'max:254'],
            'num_bathrooms' => ['nullable', 'numeric', 'min:0', 'max:254'],
            'mt_square' => ['nullable', 'numeric', 'min:10', 'max:2500'],
        ];
    }
}
