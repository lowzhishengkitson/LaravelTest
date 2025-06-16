<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tzsk\Otp\Facades\Otp;

class VerifyOtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'regex:/^\+?[1-9]\d{1,14}$/'],
            'otp' => ['required', 'digits:6'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Mobile number format is invalid.',
            'otp.required' => 'OTP is required.',
            'otp.digits' => 'OTP must be 6 digits.',
        ];
    }

    /**
     * Custom validation for OTP matching.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!Otp::check($this->otp, $this->mobile)) {
                $validator->errors()->add('otp', 'The provided OTP is invalid or expired.');
            }
        });
    }
}
