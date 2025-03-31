<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthenticationException) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($e instanceof AuthorizationException) {
            return response()->json(['message' => 'Forbidden!'], 403);
        }
        if ($e instanceof NotFoundException) {
            return response()->json(['message' => 'Nie znaleziono zasobu!'], 404);
        }
        if ($e instanceof ConflictException) {
            return response()->json(['message' => 'Błąd integrlaności danych!'], 409);
        }

        return parent::render($request, $e);
    }
}
