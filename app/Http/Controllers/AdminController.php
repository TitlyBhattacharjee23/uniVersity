<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function homepage($id)
    {
        return view('welcome', ['admin_id' => $admin_id]);
    }
    public function index()
    {

        $admin = DB::table('admin')->get();
        return view('adminPage',compact('admin'));
    }
}

