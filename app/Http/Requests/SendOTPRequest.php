<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\User;

class SendOtpRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'regex:/^\+?[1-9]\d{1,14}$/'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Please enter a valid mobile number (E.164 format).',
        ];
    }

    /**
     * Add custom validation after the initial rules.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!User::where('mobile', $this->mobile)->exists()) {
                $validator->errors()->add('mobile', 'This mobile number is not registered.');
            }
        });
    }
}
