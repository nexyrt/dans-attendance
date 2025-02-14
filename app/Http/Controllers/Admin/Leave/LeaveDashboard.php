<?php

namespace App\Http\Controllers\Admin\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveDashboard extends Controller
{
    public function index(){
        return view("admin.leave.leave-dashboard");
    }
}
