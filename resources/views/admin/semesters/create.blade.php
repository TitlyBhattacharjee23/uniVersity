@extends('layout.admin')


@section('title')
Create Semester
@endsection


@section('content')
<div class="container mt-4">
   <div class="card">
       <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
           <h3 class="mb-0">Create Semester</h3>
           <a href="{{ route('admin.semesters.index', $admin_id) }}" class="btn btn-light">Back</a>
       </div>


       <div class="card-body">
           <form action="{{ route('admin.semesters.store', $admin_id) }}" method="POST">
               @csrf
               <div class="mb-3">
                   <label for="name">Semester Name</label>
                   <input type="text" name="name" class="form-control" value="{{ old('name') }}" required/>
                   @error('name')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>
               <div class="mb-3">
                   <label for="advisor_id">Advisor</label>
                   <select name="advisor_id" class="form-control" required>
                       <option value="">Select Advisor</option>
                       @foreach($teachers as $teacher)
                           <option value="{{ $teacher->teacher_id }}" {{ old('advisor_id') == $teacher->teacher_id ? 'selected' : '' }}>
                               {{ $teacher->name }}
                           </option>
                       @endforeach
                   </select>
                   @error('advisor_id')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>
               <div class="mb-3">
                   <button type="submit" class="btn btn-primary">Create Semester</button>
               </div>
           </form>
       </div>
   </div>
</div>
@endsection

