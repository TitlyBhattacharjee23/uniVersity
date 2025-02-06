<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvisorController extends Controller
{
    public function homepage($id)
    {
        $advisor_id = $id;
        return view('welcome', ['advisor_id' => $advisor_id]);
    }
    public function index()
    {

        $advisor = DB::table('advisor')->get();
        return view('advisorPage',compact('advisor'));
    }
}

