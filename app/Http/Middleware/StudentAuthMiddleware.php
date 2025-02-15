<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class StudentAuthMiddleware
{
   public function handle(Request $request, Closure $next): Response
   {
       if (!Auth::guard('student')->check()) {
           return redirect()->route('student.login');
       }


       // Check if student is accessing their own profile
       $studentId = $request->route('id');
       if ($studentId && Auth::guard('student')->user()->student_id != $studentId) {
           return redirect("/student/" . Auth::guard('student')->user()->student_id);
       }


       return $next($request);
   }
}

