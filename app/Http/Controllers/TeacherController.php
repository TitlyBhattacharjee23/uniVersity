<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function homepage($id)
    {
        $teacher_id = $id;
        return view('welcome', ['teacher_id' => $teacher_id]);
    }
    public function index()
    {

        $teacher = DB::table('teacher')->get();
        return view('teacherPage',compact('teacher'));
    }
}


