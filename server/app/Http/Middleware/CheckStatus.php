<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $status)
    {
        // Kiểm tra nếu người dùng đã đăng nhập và có role hợp lệ
        if (Auth::check() && Auth::user()->status !== $status) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Tài khoản đã ngừng hoạt động yêu cầu liên hệ 0834983286 để nhận sự hỗ trợ!'
            ], 403);
        }

        return $next($request);
    }
}
