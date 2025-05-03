<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Enrollment;


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


   public function downloadResults($enrollment_id)
   {
       // Get the enrollment with all necessary relationships
       $enrollment = Enrollment::with([
           'student',
           'semester',
           'session',
           'results.course.teacher'
       ])->findOrFail($enrollment_id);


       // Check if the authenticated student is accessing their own results
       if (Auth::guard('student')->user()->student_id != $enrollment->student_id) {
           return redirect()->back()->with('error', 'Unauthorized access');
       }


       // Calculate GPA
       $totalPoints = 0;
       $totalCredits = 0;
       foreach ($enrollment->results as $result) {
           if ($result->grade) {
               $gradePoint = $this->gradeToPoint($result->grade);
               $totalPoints += ($gradePoint * $result->course->credit);
               $totalCredits += $result->course->credit;
           }
       }
       $gpa = $totalCredits > 0 ? ($totalPoints / $totalCredits) : 0;


       // Generate PDF
       $pdf = PDF::loadView('student.results.pdf', compact('enrollment', 'gpa'));

       // Set filename
       $filename = "Results_{$enrollment->semester->name}_{$enrollment->session->name}.pdf";

       // Download the PDF
       return $pdf->download($filename);
   }

   public function downloadEnrollments()
   {
       // Get the authenticated student with all enrollments
       $student = Student::with([
           'enrollments.session',
           'enrollments.semester.advisor',
           'enrollments.semester.courses.teacher'
       ])->findOrFail(Auth::guard('student')->user()->student_id);

       // Generate PDF
       $pdf = PDF::loadView('student.enrollments.pdf', compact('student'));

       // Set filename
       $filename = "Enrollment_History_{$student->name}.pdf";

       // Download the PDF
       return $pdf->download($filename);
   }



   private function gradeToPoint($grade)
   {
       return match($grade) {
           'A+' => 4.00,
           'A'  => 3.75,
           'A-' => 3.50,
           'B+' => 3.25,
           'B'  => 3.00,
           'B-' => 2.75,
           'C+' => 2.50,
           'C'  => 2.25,
           'C-' => 2.00,
           'D+' => 1.75,
           'D'  => 1.50,
           'F'  => 0.00,
           default => 0.00
       };
   }
}











