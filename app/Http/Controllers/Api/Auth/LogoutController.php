<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    use ResultService;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            $this->setResult($request)->setStatus(true)->setMessage('Success Logout')->setCode(JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            $errors['message'] = $e->getMessage();
            $errors['file'] = $e->getFile();
            $errors['line'] = $e->getLine();
            Log::channel('daily')->error('LogoutController', $errors);
            $this->setResult($errors)->setStatus(false)->setMessage('An error occurred on the server')->setCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->toJson();
    }
}
