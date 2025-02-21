<?php


namespace App\Http\Controllers;


use App\Models\AcademicCourse;
use App\Models\Teacher;
use App\Models\AcademicSemester;
use Illuminate\Http\Request;


class CourseController extends Controller
{
   public function index($admin_id, $semester_id)
   {
       $semester = AcademicSemester::findOrFail($semester_id);
       $courses = AcademicCourse::where('semester_id', $semester_id)->with('teacher')->get();
       return view('admin.courses.index', compact('courses', 'admin_id', 'semester'));
   }


   public function create($admin_id, $semester_id)
   {
       $semester = AcademicSemester::findOrFail($semester_id);
       $teachers = Teacher::all();
       return view('admin.courses.create', compact('admin_id', 'semester', 'teachers'));
   }


   public function store(Request $request, $admin_id, $semester_id)
   {
       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'code' => 'required|string|unique:academic_courses,code',
           'teacher_id' => 'required|exists:teachers,teacher_id'
       ]);


       $validated['semester_id'] = $semester_id;


       AcademicCourse::create($validated);


       return redirect()->route('admin.semesters.index', $admin_id)
           ->with('success', 'Course created successfully');
   }


   public function edit($admin_id, $semester_id, $course_id)
   {
       $course = AcademicCourse::findOrFail($course_id);
       $semester = AcademicSemester::findOrFail($semester_id);
       $teachers = Teacher::all();
       return view('admin.courses.edit', compact('course', 'admin_id', 'semester', 'teachers'));
   }


   public function update(Request $request, $admin_id, $semester_id, $course_id)
   {
       $course = AcademicCourse::findOrFail($course_id);


       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'code' => 'required|string|unique:academic_courses,code,' . $course_id . ',course_id',
           'teacher_id' => 'required|exists:teachers,teacher_id'
       ]);


       $course->update($validated);


       return redirect()->route('admin.semesters.index', $admin_id)
           ->with('success', 'Course updated successfully');
   }
}

