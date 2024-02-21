<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateApartmentRequest extends FormRequest
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
            'title' => ['required', 'min:5', 'max:50', Rule::unique('apartments')->ignore($this->apartment)],
            'visibility' => ['required', 'boolean'],
            'services' => ['nullable', 'exists:services,id'],
            'num_rooms' => ['nullable', 'numeric', 'min:0', 'max:254'],
            'num_beds' => ['nullable', 'numeric', 'min:0', 'max:254'],
            'num_bathrooms' => ['nullable', 'numeric', 'min:0', 'max:254'],
            'mt_square' => ['nullable', 'numeric', 'min:10', 'max:2500'],
        ];
    }
}
