<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {
            // If the request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Session expired',
                    'code' => 419
                ], 419);
            }
            
            // For regular requests, redirect to login page
            if ($request->user()) {
                auth()->logout();
            }
            
            // You can also flash a message to the session
            session()->flash('message', 'Your session has expired. Please log in again.');
            
            // Redirect to login page
            return redirect()->route('login');
        }
    }
}
