@extends('layout.admin')


@section('title')
Academic Semesters
@endsection


@section('content')
<div class="container mt-4">
   <div class="card">
       <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
           <h3 class="mb-0">Academic Semesters</h3>
           <div>
               <a href="{{ route('admin.semesters.create', $admin_id) }}" class="btn btn-light">
                   Add Semester
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


           <div class="row">
               @foreach($semesters as $semester)
               <div class="col-12 mb-4">
                   <div class="card">
                       <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                           <div>
                               <h4 class="mb-0">{{ $semester->name }}</h4>
                               <small>Advisor: {{ $semester->advisor->name }}</small>
                           </div>
                           <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                               data-bs-target="#addCourseModal{{ $semester->semester_id }}">
                               Add Course
                           </button>
                       </div>
                       <div class="card-body">
                           @if($semester->courses->count() > 0)
                               <div class="table-responsive">
                                   <table class="table">
                                       <thead>
                                           <tr>
                                               <th>Course Name</th>
                                               <th>Code</th>
                                               <th>Teacher</th>
                                               <th>Actions</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach($semester->courses as $course)
                                           <tr>
                                               <td>{{ $course->name }}</td>
                                               <td>{{ $course->code }}</td>
                                               <td>{{ $course->teacher->name }}</td>
                                               <td>
                                                   <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                       data-bs-target="#editCourseModal{{ $course->course_id }}">
                                                       Edit
                                                   </button>
                                               </td>
                                           </tr>
                                           @endforeach
                                       </tbody>
                                   </table>
                               </div>
                           @else
                               <p class="text-muted mb-0">No courses added yet.</p>
                           @endif
                       </div>
                   </div>
               </div>


               <!-- Add Course Modal -->
               <div class="modal fade" id="addCourseModal{{ $semester->semester_id }}" tabindex="-1">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title">Add Course to {{ $semester->name }}</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                           </div>
                           <form action="{{ route('admin.semester.courses.store', ['admin_id' => $admin_id, 'semester_id' => $semester->semester_id]) }}" method="POST">
                               @csrf
                               <div class="modal-body">
                                   <div class="mb-3">
                                       <label for="name">Course Name</label>
                                       <input type="text" name="name" class="form-control" required/>
                                   </div>
                                   <div class="mb-3">
                                       <label for="code">Course Code</label>
                                       <input type="text" name="code" class="form-control" required/>
                                   </div>
                                   <div class="mb-3">
                                       <label for="teacher_id">Teacher</label>
                                       <select name="teacher_id" class="form-control" required>
                                           <option value="">Select Teacher</option>
                                           @foreach($teachers as $teacher)
                                               <option value="{{ $teacher->teacher_id }}">
                                                   {{ $teacher->name }}
                                               </option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                   <button type="submit" class="btn btn-primary">Add Course</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>


               <!-- Edit Course Modal -->
               @foreach($semester->courses as $course)
               <div class="modal fade" id="editCourseModal{{ $course->course_id }}" tabindex="-1">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title">Edit Course</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                           </div>
                           <form action="{{ route('admin.semester.courses.update', ['admin_id' => $admin_id, 'semester_id' => $semester->semester_id, 'course_id' => $course->course_id]) }}" method="POST">
                               @csrf
                               @method('PUT')
                               <div class="modal-body">
                                   <div class="mb-3">
                                       <label for="name">Course Name</label>
                                       <input type="text" name="name" class="form-control" value="{{ $course->name }}" required/>
                                   </div>
                                   <div class="mb-3">
                                       <label for="code">Course Code</label>
                                       <input type="text" name="code" class="form-control" value="{{ $course->code }}" required/>
                                   </div>
                                   <div class="mb-3">
                                       <label for="teacher_id">Teacher</label>
                                       <select name="teacher_id" class="form-control" required>
                                           <option value="">Select Teacher</option>
                                           @foreach($teachers as $teacher)
                                               <option value="{{ $teacher->teacher_id }}" {{ $teacher->teacher_id == $course->teacher_id ? 'selected' : '' }}>
                                                   {{ $teacher->name }}
                                               </option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                   <button type="submit" class="btn btn-primary">Update Course</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
               @endforeach
               @endforeach
           </div>
       </div>
   </div>
</div>
@endsection

