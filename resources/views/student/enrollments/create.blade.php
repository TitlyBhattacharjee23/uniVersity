@extends('layout.student')


@section('title')
Create Enrollment
@endsection


@section('content')
<div class="container mt-4">
   <div class="card">
       <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
           <h3 class="mb-0">Create Enrollment</h3>
           <a href="{{ route('student.profile', $student_id) }}" class="btn btn-light">Back</a>
       </div>


       <div class="card-body">
           <form action="{{ route('student.enrollments.store', $student_id) }}" method="POST">
               @csrf
               <div class="mb-3">
                   <label for="session_id">Academic Session</label>
                   <select name="session_id" class="form-control" required>
                       <option value="">Select Session</option>
                       @foreach($sessions as $session)
                           <option value="{{ $session->session_id }}" {{ old('session_id') == $session->session_id ? 'selected' : '' }}>
                               {{ $session->name }} ({{ $session->start_date }} - {{ $session->end_date }})
                           </option>
                       @endforeach
                   </select>
                   @error('session_id')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>


               <div class="mb-3">
                   <label for="semester_id">Semester</label>
                   <select name="semester_id" class="form-control" required>
                       <option value="">Select Semester</option>
                       @foreach($semesters as $semester)
                           <option value="{{ $semester->semester_id }}" {{ old('semester_id') == $semester->semester_id ? 'selected' : '' }}>
                               {{ $semester->name }}
                           </option>
                       @endforeach
                   </select>
                   @error('semester_id')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>


               @foreach($semesters as $semester)
                   <div class="semester-courses" id="semester-{{ $semester->semester_id }}"
                        style="{{ old('semester_id') == $semester->semester_id ? '' : 'display: none' }}">
                       <div class="card mb-4">
                           <div class="card-header bg-light">
                               <h4 class="mb-0">{{ $semester->name }}</h4>
                               <small class="text-muted">Advisor: {{ $semester->advisor->name }}</small>
                           </div>
                           <div class="card-body">
                               <div class="table-responsive">
                                   <table class="table">
                                       <thead>
                                           <tr>
                                               <th>Course Name</th>
                                               <th>Code</th>
                                               <th>Teacher</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach($semester->courses as $course)
                                               <tr>
                                                   <td>{{ $course->name }}</td>
                                                   <td>{{ $course->code }}</td>
                                                   <td>{{ $course->teacher->name }}</td>
                                               </tr>
                                           @endforeach
                                       </tbody>
                                   </table>
                               </div>


                               <div class="mt-4">
                                   <h5>Requirements</h5>
                                   <div class="card">
                                       <div class="card-body">
                                           <ul>
                                               <li>You must attend all classes regularly</li>
                                               <li>Maintain at least 75% attendance</li>
                                               <li>Complete all assignments on time</li>
                                               <li>Participate in all examinations</li>
                                           </ul>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               @endforeach


               <div class="mt-4">
                   <button type="submit" class="btn btn-primary">Enrollment</button>
               </div>
           </form>
       </div>
   </div>
</div>


<script>
document.querySelector('select[name="semester_id"]').addEventListener('change', function() {
   // Hide all semester course lists
   document.querySelectorAll('.semester-courses').forEach(div => div.style.display = 'none');

   // Show selected semester's courses
   if (this.value) {
       document.getElementById('semester-' + this.value).style.display = 'block';
   }
});
</script>
@endsection

