<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
   public function homepage($id)
   {
       // Get the student data with all necessary relationships
       $student = Student::with([
           'enrollments.session',
           'enrollments.semester.advisor',
           'enrollments.semester.courses.teacher',
           'enrollments.results.course.semester'
       ])->findOrFail($id);


       // Check if the authenticated student is accessing their own profile
       if (Auth::guard('student')->user()->student_id != $id) {
           return redirect("/student/[" . Auth::guard('student')->user()->student_id . "]");
       }


       // Group all results by course for easy access to retake information
       $courseResults = collect();
       foreach ($student->enrollments as $enrollment) {
           foreach ($enrollment->results as $result) {
               if (!$courseResults->has($result->course_id)) {
                   $courseResults[$result->course_id] = collect();
               }
               $courseResults[$result->course_id]->push($result);
           }
       }


       // Sort results within each course by date, oldest first
       $courseResults = $courseResults->map(function($results) {
           return $results->sortByDesc('enrollment.created_at')->values();
       });


       return view('student.profile', compact('student', 'courseResults'));
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





