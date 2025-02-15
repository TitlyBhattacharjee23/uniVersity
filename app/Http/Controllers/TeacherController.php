<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;


class TeacherController extends Controller
{
   public function homepage($id)
   {
       // Get the admin data
       $teacher = Teacher::findOrFail($id);

       // Check if the authenticated student is accessing their own profile
       if (Auth::guard('teacher')->user()->teacher_id != $id) {
           return redirect("/teacher/[" . Auth::guard('teacher')->user()->teacher_id  . "]");
       }


       return view('teacher.profile', compact('teacher'));
   }
}
