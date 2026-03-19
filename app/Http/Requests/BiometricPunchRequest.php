<?php

namespace App\Http\Requests;

use App\Models\BiometricPunchFailure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BiometricPunchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $now = now()->endOfDay()->toDateTimeString();
        return [
            'machine_user_id' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9_\-\\.]+$/'],
            'device_id' => ['nullable', 'string', 'max:100', 'regex:/^[A-Za-z0-9_\-\\.]+$/'],
            'scan_time' => ['required', 'date', 'before_or_equal:' . $now],
            'type' => ['nullable', 'string', 'in:Fingerprint,Face,Card'],
        ];
    }

    public function messages(): array
    {
        return [
            'machine_user_id.regex' => 'The machine user ID may only contain letters, numbers, hyphens, underscores and dots.',
            'device_id.regex' => 'The device ID may only contain letters, numbers, hyphens, underscores and dots.',
            'scan_time.before_or_equal' => 'The scan time must not be in the future.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        BiometricPunchFailure::logFailure(
            $this->all(),
            BiometricPunchFailure::REASON_VALIDATION_ERROR,
            $this->ip()
        );

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
