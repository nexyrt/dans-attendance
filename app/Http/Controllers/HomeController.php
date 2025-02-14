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
                return redirect('/admin/dashboard')->with(['user', $user]);
            }
            if ($user->role == 'manager') {
                return redirect('/manager/dashboard')->with(['user', $user]);
            }
            if ($user->role == 'staff') {
                return redirect('/staff/dashboard')->with(['user', $user]);
            }
        } else {
            return redirect('/login');
        }
    }
}
