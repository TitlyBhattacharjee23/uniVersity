<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function homepage($id)
    {
        return view('welcome', ['result_id' => $result_id]);
    }
    public function index()
    {

        $result = DB::table('result')->get();
        return view('resultPage',compact('result'));
    }
}

