<?php


namespace App\Http\Controllers;


use App\Models\Enrollment;
use App\Models\AcademicSession;
use App\Models\AcademicSemester;
use Illuminate\Http\Request;


class EnrollmentController extends Controller
{
   public function create($student_id)
   {
       $sessions = AcademicSession::orderBy('start_date', 'desc')->get();
       $semesters = AcademicSemester::with(['courses.teacher', 'advisor'])->get();


       return view('student.enrollments.create', compact('sessions', 'semesters', 'student_id'));
   }


   public function getSemesterCourses($semester_id)
   {
       $semester = AcademicSemester::with('courses.teacher')->findOrFail($semester_id);
       return response()->json([
           'courses' => $semester->courses,
           'advisor' => $semester->advisor
       ]);
   }


   public function store(Request $request, $student_id)
   {
       $validated = $request->validate([
           'session_id' => 'required|exists:academic_sessions,session_id',
           'semester_id' => 'required|exists:academic_semesters,semester_id'
       ]);


       $validated['student_id'] = $student_id;
       $validated['status'] = 'pending';


       Enrollment::create($validated);


       return redirect()->route('student.profile', $student_id)
           ->with('success', 'Enrollment completed successfully');
   }
}

