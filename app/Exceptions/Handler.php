<?php

namespace App\Exceptions;

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

    // check session expired then go to login page
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            // For AJAX/API calls
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // For regular web requests, redirect to login
        return redirect()->guest(route('login'));
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Check if token is provided in API requests
     */
    // public function render($request, Throwable $e)
    // {
    //     if ($e instanceof AuthenticationException) {
    //         return response()->json($e->getMessage());
    //     }
    //     return parent::render($request, $e);
    // }

    public function render($request, Throwable $e)
    {
        return parent::render($request, $e);
    }
}
