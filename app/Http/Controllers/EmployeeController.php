<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() 
    {
        $users = User::all();

        return view('components.admin.employee', compact('users'));
    }
}
