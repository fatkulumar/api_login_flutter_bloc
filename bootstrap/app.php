<?php

use App\Traits\ResultService;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->api(prepend: [
        //     \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        // ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $handler = new class {
            use ResultService;
        };
        $exceptions->render(function (Throwable $e) use ($handler) {
            if ($e instanceof AuthenticationException) {
            $statusCode = JsonResponse::HTTP_UNAUTHORIZED;
            } elseif ($e instanceof ValidationException) {
                $statusCode = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            } elseif ($e instanceof HttpExceptionInterface) {
                $statusCode = $e->getStatusCode();
            } else {
                $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
            }

            Log::channel('daily')->error('Exception caught in global handler', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                // 'line' => $e->getLine(),
                // 'trace' => $e->getTraceAsString(),
            ]);

            $handler->setResult($e)->setStatus(false)->setMessage($e->getMessage())->setCode($statusCode);
            return $handler->toJson();
        });
    })->create();
