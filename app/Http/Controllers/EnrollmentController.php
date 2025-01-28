<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function homepage($id)
    {
        return view('welcome', ['enrollment_id' => $enrollment_id]);
    }
    public function index()
    {

        $enrollment = DB::table('enrollment')->get();
        return view('enrollmentPage',compact('enrollment'));
    }
}

