<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roles = explode(',', $roles);
        // Kiểm tra nếu người dùng đã đăng nhập và có role hợp lệ
        if (Auth::check() && !in_array(Auth::user()->role, $roles)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Người dùng không đủ quyền để thực hiện!'
            ], 401);
        }

        return $next($request);
    }
}
