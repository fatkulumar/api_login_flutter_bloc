<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
            // 'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

     public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama berisi harus huruf.',
            'name.max' => 'Nama maksimal 255 Karakter.',
            'email.required' => 'Email harus diisi.',
            'email.string' => 'Email harus berisi huruf.',
            'email.lowercase' => 'Email harus huruf kecil.',
            'email.email' => 'Harus berformat email.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email pernah terfadtar.',
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
            'name' => strtolower(trim($this->name)),
            'email' => strtolower(trim($this->email)),
        ]);
    }
}
