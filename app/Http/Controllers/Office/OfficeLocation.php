<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfficeLocation extends Controller
{

    //
    public function index(){
        return view("admin.office.index");
    }
}
