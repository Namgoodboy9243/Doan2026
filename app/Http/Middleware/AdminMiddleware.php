<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập quyền quản trị!',
                    'redirect' => route('admin.login')
                ], 401);
            }

            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị!');
        }

        if (Auth::user()->is_admin != 1) {
            // Đăng xuất phiên hiện tại của user thường
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Tài khoản của bạn không có quyền truy cập trang quản trị!',
                    'redirect' => route('admin.login')
                ], 403);
            }

            return redirect()->route('admin.login')->with('error', 'Tài khoản của bạn không có quyền truy cập trang quản trị!');
        }

        return $next($request);
    }
}
