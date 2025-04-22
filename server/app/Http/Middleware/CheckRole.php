<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roles = explode(',', $roles);

        if (!Auth::check()) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Vui lòng đăng nhập để tiếp tục!'
            ], 401);
        }

        // Kiểm tra nếu người dùng đã đăng nhập và có role hợp lệ
        if (Auth::check() && !in_array(Auth::user()->role, $roles)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Người dùng không đủ quyền để thực hiện!'
            ], 403);
        }

        return $next($request);
    }
}