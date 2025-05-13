<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    use ResultService;
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        $token = $user->createToken('YourAppName')->plainTextToken;

        $this->setResult($token)->setStatus(true)->setMessage('Berhasil Login')->setCode(JsonResponse::HTTP_OK);

        return $this->toJson();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->setResult($request)->setStatus(true)->setMessage('Berhasil Logout')->setCode(JsonResponse::HTTP_OK);

        return $this->toJson();
    }
}
