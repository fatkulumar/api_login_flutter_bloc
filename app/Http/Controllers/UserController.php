<?php

namespace App\Http\Controllers;

use App\Traits\ResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ResultService;
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $this->setResult(Auth::user())->setStatus(true)->setMessage('Data Ditemukan')->setCode(JsonResponse::HTTP_OK);
        return $this->toJson();
    }
}
