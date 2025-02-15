@extends('layout.admin')


@section('title')
Edit Academic Session
@endsection


@section('content')
<div class="container mt-4">
   <div class="card">
       <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
           <h3 class="mb-0">Edit Academic Session</h3>
           <a href="{{ route('admin.sessions.index', $admin_id) }}" class="btn btn-light">Back</a>
       </div>


       <div class="card-body">
           <form action="{{ route('admin.sessions.update', ['admin_id' => $admin_id, 'session_id' => $session->session_id]) }}" method="POST">
               @csrf
               @method('PUT')
               <div class="mb-3">
                   <label for="name">Session Name</label>
                   <input type="text" name="name" class="form-control" value="{{ $session->name }}" required/>
                   @error('name')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>
               <div class="mb-3">
                   <label for="start_date">Start Date</label>
                   <input type="date" name="start_date" class="form-control" value="{{ $session->start_date }}" required/>
                   @error('start_date')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>
               <div class="mb-3">
                   <label for="end_date">End Date</label>
                   <input type="date" name="end_date" class="form-control" value="{{ $session->end_date }}" required/>
                   @error('end_date')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>
               <div class="mb-3">
                   <button type="submit" class="btn btn-primary">Update</button>
               </div>
           </form>
       </div>
   </div>
</div>
@endsection
