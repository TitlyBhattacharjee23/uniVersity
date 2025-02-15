@extends('layout.admin')


@section('title')
Academic Sessions
@endsection


@section('content')
<div class="container mt-4">
   <div class="card">
       <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
           <h3 class="mb-0">Academic Sessions</h3>
           <div>
               <a href="{{ route('admin.sessions.create', $admin_id) }}" class="btn btn-light">
                   Add Session
               </a>
               <a href="{{ route('admin.profile', $admin_id) }}" class="btn btn-light ms-2">
                   Back to Profile
               </a>
           </div>
       </div>


       <div class="card-body">
           @if(session('success'))
               <div class="alert alert-success">
                   {{ session('success') }}
               </div>
           @endif


           <div class="table-responsive">
               <table class="table">
                   <thead>
                       <tr>
                           <th>Session Name</th>
                           <th>Start Date</th>
                           <th>End Date</th>
                           <th>Action</th>
                       </tr>
                   </thead>
                   <tbody>
                       @foreach($sessions as $session)
                       <tr>
                           <td>{{ $session->name }}</td>
                           <td>{{ \Carbon\Carbon::parse($session->start_date)->format('d M Y') }}</td>
                           <td>{{ \Carbon\Carbon::parse($session->end_date)->format('d M Y') }}</td>
                           <td>
                               <a href="{{ route('admin.sessions.edit', ['admin_id' => $admin_id, 'session_id' => $session->session_id]) }}"
                                  class="btn btn-sm btn-primary">
                                   Update
                               </a>
                           </td>
                       </tr>
                       @endforeach
                   </tbody>
               </table>
           </div>
       </div>
   </div>
</div>
@endsection
