<?php


namespace App\Http\Controllers;


use App\Models\AcademicSession;
use Illuminate\Http\Request;


class SessionController extends Controller
{
   public function index($admin_id)
   {
       $sessions = AcademicSession::orderBy('start_date', 'desc')->get();
       return view('admin.sessions.index', compact('sessions', 'admin_id'));
   }


   public function create($admin_id)
   {
       return view('admin.sessions.create', compact('admin_id'));
   }


   public function store(Request $request, $admin_id)
   {
       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'start_date' => 'required|date',
           'end_date' => 'required|date|after:start_date',
       ]);


       AcademicSession::create($validated);


       return redirect()->route('admin.sessions.index', $admin_id)
           ->with('success', 'Session created successfully');
   }


   public function edit($admin_id, $session_id)
   {
       $session = AcademicSession::findOrFail($session_id);
       return view('admin.sessions.edit', compact('session', 'admin_id'));
   }


   public function update(Request $request, $admin_id, $session_id)
   {
       $session = AcademicSession::findOrFail($session_id);


       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'start_date' => 'required|date',
           'end_date' => 'required|date|after:start_date',
       ]);


       $session->update($validated);


       return redirect()->route('admin.sessions.index', $admin_id)
           ->with('success', 'Session updated successfully');
   }


   public function destroy($admin_id, $session_id)
   {
       $session = AcademicSession::findOrFail($session_id);
       $session->delete();


       return redirect()->route('admin.sessions.index', $admin_id)
           ->with('success', 'Session deleted successfully');
   }
}


