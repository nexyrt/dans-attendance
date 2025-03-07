<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect berdasarkan role
                $user = Auth::user();
                
                return match($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'staff' => redirect()->route('staff.dashboard'),
                    'manager' => redirect()->route('manager.leave.index'),  // jika ada
                    'director' => redirect()->route('director.dashboard'),  // jika ada
                    default => redirect(RouteServiceProvider::HOME),
                };
            }
        }

        return $next($request);
    }
}
