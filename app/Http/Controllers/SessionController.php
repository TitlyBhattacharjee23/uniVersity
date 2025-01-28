<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function homepage($id)
    {
        return view('welcome', ['session_id' => $session_id]);
    }
    public function index()
    {

        $session = DB::table('session')->get();
        return view('sessionPage',compact('session'));
    }
}

