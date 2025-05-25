<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use ResultService;
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        try {
            $errorPassword = [
                "password" => ["Password Salah."]
            ];
            $user = User::where('email', $request->post('email'))->first();
            if (!Hash::check($request->post('password'), $user->password)) {
                $this->setResult($errorPassword)->setStatus(false)->setMessage('Password salah')->setCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                return $this->toJson();
            }

            Auth::login($user);
            $auth = Auth::user();
            $token = $auth->createToken('AppToken')->plainTextToken;

            $this->setResult($token)->setStatus(true)->setMessage('Berhasil Login')->setCode(JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            $errors['message'] = $e->getMessage();
            $errors['file'] = $e->getFile();
            $errors['line'] = $e->getLine();
            Log::channel('daily')->error('LoginController', $errors);
            $this->setResult($errors)->setStatus(false)->setMessage('An error occurred on the server')->setCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->toJson();
    }
}
