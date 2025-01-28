<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function homepage($id)
    {
        return view('welcome', ['course_id' => $course_id]);
    }
    public function index()
    {

        $course = DB::table('course')->get();
        return view('coursePage',compact('course'));
    }
}

