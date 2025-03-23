<?php


namespace App\Http\Controllers;


use App\Models\Enrollment;
use App\Models\AcademicSession;
use App\Models\AcademicSemester;
use App\Models\Result;
use App\Models\AcademicCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class EnrollmentController extends Controller
{
   public function create($student_id)
   {
       // Get failed courses from previous enrollments
       $failedCourses = Result::whereHas('enrollment', function($query) use ($student_id) {
           $query->where('student_id', $student_id);
       })
       ->where('grade', 'F')
       ->with(['course', 'enrollment.semester'])
       ->get();


       $sessions = AcademicSession::orderBy('start_date', 'desc')->get();
       $semesters = AcademicSemester::with(['courses.teacher', 'advisor'])->get();


       return view('student.enrollments.create', compact(
           'sessions',
           'semesters',
           'student_id',
           'failedCourses'
       ));
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
       try {
           // Validate basic request data
           $validated = $request->validate([
               'session_id' => 'required|exists:academic_sessions,session_id',
               'semester_id' => 'required|exists:academic_semesters,semester_id',
               'course_ids' => 'required|array',
               'course_ids.*' => 'exists:academic_courses,course_id'
           ]);


           // Get failed courses
           $failedCourses = Result::whereHas('enrollment', function($query) use ($student_id) {
               $query->where('student_id', $student_id);
           })
           ->where('grade', 'F')
           ->pluck('course_id')
           ->toArray();


           // Calculate total credits
           $totalCredits = AcademicCourse::whereIn('course_id', $validated['course_ids'])
               ->sum('credit');


           // Add failed courses credits
           $failedCredits = AcademicCourse::whereIn('course_id', $failedCourses)
               ->sum('credit');


           $totalCredits += $failedCredits;


           // Check credit limit
           if ($totalCredits > 28) {
               return back()
                   ->withInput()
                   ->with('error', "Total credits ($totalCredits) exceed the limit of 28 hours.");
           }


           DB::beginTransaction();


           try {
               // Create enrollment
               $enrollment = Enrollment::create([
                   'student_id' => $student_id,
                   'session_id' => $validated['session_id'],
                   'semester_id' => $validated['semester_id'],
                   'status' => 'pending',
                   'requirements_checked' => false
               ]);


               // Create results for failed courses (retakes)
               foreach ($failedCourses as $courseId) {
                   Result::create([
                       'enrollment_id' => $enrollment->enrollment_id,
                       'course_id' => $courseId,
                       'remarks' => 'Retake'
                   ]);
               }


               // Create results for new courses
               foreach ($validated['course_ids'] as $courseId) {
                   if (!in_array($courseId, $failedCourses)) {
                       Result::create([
                           'enrollment_id' => $enrollment->enrollment_id,
                           'course_id' => $courseId,
                           'remarks' => 'New Enrollment'
                       ]);
                   }
               }


               DB::commit();


               return redirect()
                   ->route('student.profile', $student_id)
                   ->with('success', "Enrollment completed successfully with total credits: $totalCredits");


           } catch (\Exception $e) {
               DB::rollBack();
               Log::error('Enrollment creation failed: ' . $e->getMessage());
               return back()
                   ->withInput()
                   ->with('error', 'Failed to create enrollment. Please try again.');
           }


       } catch (\Exception $e) {
           Log::error('Enrollment validation failed: ' . $e->getMessage());
           return back()
               ->withInput()
               ->with('error', 'Invalid enrollment data. Please check your selections.');
       }
   }
}
