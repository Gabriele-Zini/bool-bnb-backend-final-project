<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreSponsorshipRequest extends FormRequest
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
          'sponsorship_id'=>['required'],
          'start_date'=>['required', 'after:yesterday'],
          'start_time'=>['required'],
        ];
    }

    public function messages()
    {
        return [
            'sponsorship_id' => 'Please select a sponsorship',
        ];
    }
}
