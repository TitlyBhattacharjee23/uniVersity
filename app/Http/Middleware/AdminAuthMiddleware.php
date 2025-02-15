<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AdminAuthMiddleware
{
   public function handle(Request $request, Closure $next): Response
   {
       if (!Auth::guard('admin')->check()) {
           return redirect()->route('auth.login');
       }


       // Check if admin is accessing their own profile
       $adminId = $request->route('id');
       if ($adminId && Auth::guard('admin')->user()->admin_id != $adminId) {
           return redirect("/admin/" . Auth::guard('admin')->user()->admin_id);
       }


       return $next($request);
   }
}
