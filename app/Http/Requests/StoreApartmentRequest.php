<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
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
            'title' => ['required', 'min:5', 'max:50', 'unique:apartments'],
            'image_path' => ['image', 'nullable'],
            'visibility' => ['required', 'boolean'],
            'city' => ['required', 'min:2', 'max:200'],
            'street_name' => ['required', 'min:5', 'max:200'],
            'street_number' => ['required', 'min:1', 'max:6'],
            'postal_code' => ['required', 'min:2', 'max:14'],
            'country_code' => ['required'],
            'services' => ['nullable', 'exists:services,id'],
            'num_rooms' => ['nullable', 'numeric', 'max:254'],
            'num_beds' => ['nullable', 'numeric', 'max:254'],
            'num_bathrooms' => ['nullable', 'numeric', 'max:254'],
            'mt_square' => ['nullable', 'numeric', 'max:2500'],
        ];
    }

    public function messages()
    {
        return [
            'title.min' => 'gay',
        ];
    }
}
