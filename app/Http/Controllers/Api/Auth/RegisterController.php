<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use ResultService;

    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->string('name'),
                'email' => $request->post('email'),
                'password' => Hash::make($request->string('password')),
            ]);

            Auth::login($user);
            $token = $user->createToken('YourAppName')->plainTextToken;

            $this->setResult($token)->setStatus(true)->setMessage('Berhasil Register')->setCode(JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            $errors['message'] = $e->getMessage();
            $errors['file'] = $e->getFile();
            $errors['line'] = $e->getLine();
            Log::channel('daily')->error('RegisterController', $errors);
            $this->setResult($errors)->setStatus(false)->setMessage('An error occurred on the server')->setCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->toJson();
    }
}
