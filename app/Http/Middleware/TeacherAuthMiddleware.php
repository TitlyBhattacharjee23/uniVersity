<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class TeacherAuthMiddleware
{
   public function handle(Request $request, Closure $next): Response
   {
       if (!Auth::guard('teacher')->check()) {
           return redirect()->route('auth.login');
       }


       // Only check profile access for the profile route
       if ($request->is('teacher/*') && !$request->is('teacher/enrollments/*')) {
           $teacherId = $request->route('id');
           if ($teacherId && Auth::guard('teacher')->user()->teacher_id != $teacherId) {
               return redirect("/teacher/" . Auth::guard('teacher')->user()->teacher_id);
           }
       }


       return $next($request);
   }
}
