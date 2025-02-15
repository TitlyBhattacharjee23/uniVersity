<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
   public function homepage($id)
   {
       // Get the admin data
       $admin = Admin::findOrFail($id);

       // Check if the authenticated student is accessing their own profile
       if (Auth::guard('admin')->user()->admin_id != $id) {
           return redirect("/admin/[" . Auth::guard('admin')->user()->admin_id  . "]");
       }


       return view('admin.profile', compact('admin'));
   }
}
