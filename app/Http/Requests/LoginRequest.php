<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            // 'password' => ['required', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'Email tidak terdaftar.',
            // 'password.required' => 'Password wajib diisi.',
            // 'password.min' => 'Password minimal 8 karakter.',
            // 'password.confirmed' => 'Konfirmasi password tidak cocok.',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => false,
            'message' => 'Entitas Tidak Terpenuhi',
            'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'data' => $validator->errors(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }

    public function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower(trim($this->email)),
            'password' => strtolower(trim($this->password)),
        ]);
    }
}
