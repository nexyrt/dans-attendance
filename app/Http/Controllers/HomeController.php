<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role == 'user') {
                return redirect('/employee/dashboard');
            } else {
                // Handle other roles or default redirect
                return redirect('/dashboard');
            }
        } else {
            return redirect('/login');
        }
    }
}
