<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        return view('admin.schedule.index');
    }

    public function shift()
    {
        return view('admin.schedule.shift');
    }
}
