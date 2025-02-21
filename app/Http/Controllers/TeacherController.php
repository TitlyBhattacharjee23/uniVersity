<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;


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


}
