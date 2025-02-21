<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
   public function homepage($id)
   {
       // Get the student data
       $student = Student::with([
           'enrollments.session',
           'enrollments.semester.advisor',
           'enrollments.semester.courses.teacher'
       ])->findOrFail($id);


       // Check if the authenticated student is accessing their own profile
       if (Auth::guard('student')->user()->student_id != $id) {
           return redirect("/student/[" . Auth::guard('student')->user()->student_id . "]");
       }


       return view('student.profile', compact('student'));
   }


   public function updateProfile(Request $request, $id)
   {
       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|email|unique:students,email,' . $id . ',student_id',
           'dob' => 'required|date',
           'address' => 'required|string|max:500'
       ]);


       $student = Student::findOrFail($id);
       $student->update($validated);


       return back()->with('success', 'Profile updated successfully');
   }
}



