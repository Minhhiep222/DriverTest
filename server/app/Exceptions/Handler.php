<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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

    public function render($request, Throwable $exception)
    {
        // Nếu là lỗi xác thực (AuthenticationException)
        if ($exception instanceof AuthenticationException) {
            return Response::json([
                'message' => 'Vui lòng đăng nhập để truy cập tài nguyên này.',
            ], 401); // Trả về mã lỗi 401: Unauthorized
        }

        // Nếu là lỗi không có quyền truy cập
        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return Response::json([
                'message' => 'Bạn không có quyền truy cập vào tài nguyên này.',
            ], 403); // Trả về mã lỗi 403: Forbidden
        }

        return parent::render($request, $exception);
    }
}