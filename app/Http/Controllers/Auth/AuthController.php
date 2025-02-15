<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
   public function __construct()
   {
       $this->middleware('guest:student')->except('logout');
   }


   public function showLoginForm()
   {
       return view('auth.custom.login');
   }


   public function showRegistrationForm()
   {
       return view('auth.custom.register');
   }


   public function register(Request $request)
   {
       $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:students',
           'password' => 'required|string|min:8|confirmed',
           'dob' => 'required|date|before:today',
           'address' => 'required|string|max:500'
       ]);


       $student = Student::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'dob' => $request->dob,         // Added DOB
           'address' => $request->address  // Added address
       ]);


       Auth::guard('student')->login($student);


       return redirect("/student/[{$student->student_id}]");
   }


   public function login(Request $request)
   {
       $credentials = $request->validate([
           'email' => 'required|email',
           'password' => 'required',
       ]);


       // Try admin login first
       if (Auth::guard('admin')->attempt($credentials)) {
           $request->session()->regenerate();
           $admin_id = Auth::guard('admin')->user()->admin_id;
           return redirect("/admin/[{$admin_id}]");
       }


       // Try teacher login next
       if (Auth::guard('teacher')->attempt($credentials)) {
           $request->session()->regenerate();
           $teacher_id = Auth::guard('teacher')->user()->teacher_id;
           return redirect("/teacher/[{$teacher_id}]");
       }


       // Finally try student login
       if (Auth::guard('student')->attempt($credentials)) {
           $request->session()->regenerate();
           $student_id = Auth::guard('student')->user()->student_id;
           return redirect("/student/[{$student_id}]");
       }


       // If none of the above work, return with error
       return back()->withErrors([
           'email' => 'The provided credentials do not match our records.',
       ]);
   }


   public function logout(Request $request)
   {
        // Check which guard the user is authenticated with and logout accordingly
        if (Auth::guard('admin')->check()) {
           Auth::guard('admin')->logout();
       } elseif (Auth::guard('teacher')->check()) {
           Auth::guard('teacher')->logout();
       } elseif (Auth::guard('student')->check()) {
           Auth::guard('student')->logout();
       }


       $request->session()->invalidate();
       $request->session()->regenerateToken();
       return redirect('/');
   }
}
