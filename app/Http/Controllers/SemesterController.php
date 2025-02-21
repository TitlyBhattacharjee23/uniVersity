<?php


namespace App\Http\Controllers;


use App\Models\AcademicSemester;
use App\Models\AcademicCourse;
use App\Models\Teacher;
use Illuminate\Http\Request;


class SemesterController extends Controller
{
   public function index($admin_id)
   {
       $semesters = AcademicSemester::with(['courses.teacher'])->orderBy('created_at', 'desc')->get();
       $teachers = Teacher::all();
       return view('admin.semesters.index', compact('semesters', 'admin_id', 'teachers'));
   }


   public function create($admin_id)
   {
       $teachers = Teacher::all();
       return view('admin.semesters.create', compact('admin_id', 'teachers'));
   }


   public function store(Request $request, $admin_id)
   {
       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'advisor_id' => 'required|exists:teachers,teacher_id'
       ]);


       AcademicSemester::create($validated);


       return redirect()->route('admin.semesters.index', $admin_id)
           ->with('success', 'Semester created successfully');
   }


   public function edit($admin_id, $semester_id)
   {
       $semester = AcademicSemester::findOrFail($semester_id);
       return view('admin.semesters.edit', compact('semester', 'admin_id'));
   }


   public function update(Request $request, $admin_id, $semester_id)
   {
       $semester = AcademicSemester::findOrFail($semester_id);


       $validated = $request->validate([
           'name' => 'required|string|max:255',
       ]);


       $semester->update($validated);


       return redirect()->route('admin.semesters.index', $admin_id)
           ->with('success', 'Semester updated successfully');
   }
}

