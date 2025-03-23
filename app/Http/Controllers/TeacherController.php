<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Log;


class TeacherController extends Controller
{
   public function homepage($id)
   {
       $teacher = Teacher::with([
           'advisedSemesters.enrollments.student',
           'advisedSemesters.enrollments.session',
           'advisedSemesters.enrollments.semester.courses.teacher'
       ])->findOrFail($id);


       // Get all enrollments from semesters where this teacher is advisor
       $advisorEnrollments = collect();
       foreach ($teacher->advisedSemesters as $semester) {
           $advisorEnrollments = $advisorEnrollments->concat($semester->enrollments);
       }
       $advisorEnrollments = $advisorEnrollments->sortByDesc('created_at');


       return view('teacher.profile', compact('teacher', 'advisorEnrollments'));
   }


   public function updateEnrollmentStatus(Request $request, $enrollment_id)
   {
       // Validate the request
       $request->validate([
           'status' => 'required|in:approved,rejected',
       ]);


       // Find the enrollment
       $enrollment = Enrollment::findOrFail($enrollment_id);


       // Update the status
       $enrollment->status = $request->input('status');
       $enrollment->save();


       // Set a success message
       session()->flash('success', 'Enrollment status updated successfully.');


       // Redirect back to the dashboard
       return redirect()->back();
   }




   public function showResults($id)
   {
       // Step 1: Get all results with their relationships
       $results = Result::with([
           'enrollment.student',
           'enrollment.semester',
           'course.semester',  // Add course's semester relationship
           'course'
       ])
           // Step 2: Filter results to only show those with approved enrollments
           ->whereHas('enrollment', function($query) {
               $query->where('status', 'approved');
           })
           // Step 3: Filter results to only show those for this teacher's courses
           ->whereHas('course', function($query) use ($id) {
               $query->where('teacher_id', $id);
           })
           ->get();


       // Group results by course for display
       $courses = $results->groupBy('course_id')->map(function($courseResults) {
           return [
               'course' => $courseResults->first()->course,
               'results' => $courseResults->sortByDesc('enrollment.created_at')
           ];
       });


       return view('teacher.results.results', compact('courses'));
   }


   public function storeResult(Request $request)
   {


       $validated = $request->validate([
           'enrollment_id' => 'required|exists:enrollments,enrollment_id',
           'course_id' => 'required|exists:academic_courses,course_id',
           'marks' => 'required|numeric|min:0|max:100',
           'grade' => 'required|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
           'remarks' => 'nullable|string|max:255'
       ]);


       Result::create($validated);


       return back()->with('success', 'Result added successfully');
   }


   public function updateResult(Request $request)
   {
       $validated = $request->validate([
           'enrollment_id' => 'required|exists:enrollments,enrollment_id',
           'course_id' => 'required|exists:academic_courses,course_id',
           'marks' => 'required|numeric|min:0|max:100',
           'grade' => 'required|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
           'remarks' => 'nullable|string|max:255'
       ]);


       try {
           $result = Result::where('enrollment_id', $validated['enrollment_id'])
               ->where('course_id', $validated['course_id'])
               ->firstOrFail();


           $result->update([
               'marks' => $validated['marks'],
               'grade' => $validated['grade'],
               'remarks' => $validated['remarks']
           ]);


           return back()->with('success', 'Result updated successfully');
       } catch (\Exception $e) {
           return back()->with('error', 'Failed to update result');
       }
   }
}











