@extends('layout.student')


@section('title')
Student Profile
@endsection


@section('heading')
Student Profile Dashboard
@endsection


@section('content')
<div class="container mt-4">
   <!-- Student Info Card -->
   <div class="card mb-4">
       <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
           <h3 class="mb-0">Student Information</h3>
           <div class="d-flex gap-2">
               <a href="{{ route('student.enrollments.create', $student->student_id) }}" class="btn btn-light">
                   Create Enrollment
               </a>


               <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                   data-bs-target="#updateProfileModal">
                   Edit Profile
               </button>
           </div>
       </div>


       <div class="card-body">
           <div class="row">
               <div class="col-md-6">
                   <table class="table table-borderless">
                       <tr>
                           <th width="30%">Student ID:</th>
                           <td>{{ $student->student_id }}</td>
                       </tr>
                       <tr>
                           <th>Name:</th>
                           <td>{{ $student->name }}</td>
                       </tr>
                       <tr>
                           <th>Email:</th>
                           <td>{{ $student->email }}</td>
                       </tr>
                   </table>
               </div>
               <div class="col-md-6">
                   <table class="table table-borderless">
                       <tr>
                           <th>Date of Birth:</th>
                           <td>{{ $student->dob }}</td>
                       </tr>
                       <tr>
                           <th width="30%">Address:</th>
                           <td>{{ $student->address }}</td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
   </div>


   <!-- Enrollments List Card -->
   <div class="card">
       <div class="card-header bg-primary text-white">
           <h3 class="mb-0">Enrollment History</h3>
       </div>
       <div class="card-body">
           @if(session('success'))
               <div class="alert alert-success">
                   {{ session('success') }}
               </div>
           @endif


           @if($student->enrollments->count() > 0)
               <div class="table-responsive">
                   <table class="table table-hover">
                       <thead class="table-light">
                           <tr>
                               <th>Session</th>
                               <th>Semester</th>
                               <th>Courses</th>
                               <th>Semester Advisor</th>
                               <th>Status</th>
                               <th>Enrolled On</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach($student->enrollments->sortByDesc('created_at') as $enrollment)
                                           <tr>
                                               <td>
                                                   {{ $enrollment->session->name }}
                                                   <div class="small text-muted">
                                                       {{ $enrollment->session->start_date }} - {{ $enrollment->session->end_date }}
                                                   </div>
                                               </td>
                                               <td>{{ $enrollment->semester->name }}</td>
                                               <td>
                                                   <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse"
                                                       data-bs-target="#courseList{{ $enrollment->enrollment_id }}">
                                                       View Courses
                                                   </button>
                                                   <div class="collapse mt-2" id="courseList{{ $enrollment->enrollment_id }}">
                                                       <div class="card card-body p-2">
                                                           <ul class="list-unstyled mb-0">
                                                               @foreach($enrollment->semester->courses as $course)
                                                                   <li>
                                                                       <strong>{{ $course->code }} ({{ $course->credit }})</strong> - {{ $course->name }}
                                                                       <small class="text-muted">({{ $course->teacher->name }})</small>
                                                                   </li>
                                                               @endforeach
                                                           </ul>
                                                       </div>
                                                   </div>
                                               </td>
                                               <td>
                                                   {{ $enrollment->semester->advisor->name }}
                                                   <div class="small text-muted">
                                                       Advisor
                                                   </div>
                                               </td>
                                               <td>
                                                   <span class="badge bg-{{ $enrollment->status === 'approved' ? 'success' :
                               ($enrollment->status === 'rejected' ? 'danger' : 'warning') }}">
                                                       {{ ucfirst($enrollment->status) }}
                                                   </span>
                                               </td>
                                               <td>
                                                   {{ $enrollment->created_at->format('M d, Y') }}
                                                   <div class="small text-muted">
                                                       {{ $enrollment->created_at->format('h:i A') }}
                                                   </div>
                                               </td>
                                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           @else
               <div class="alert alert-info">
                   No enrollments found. Create your first enrollment by clicking the "Create Enrollment" button above.
               </div>
           @endif
       </div>
   </div>


   <!-- Results card -->
   <div class="card mt-4">
       <div class="card-header bg-primary text-white">
           <h3 class="mb-0">Academic Results</h3>
       </div>
       <div class="card-body">
           @if($student->enrollments->where('status', 'approved')->count() > 0)
               @foreach($student->enrollments->where('status', 'approved')->sortByDesc('created_at') as $enrollment)
                   <div class="semester-results mb-4">
                       <h4 class="text-primary">
                           {{ $enrollment->semester->name }}
                           <span class="text-muted">({{ $enrollment->session->name }})</span>
                       </h4>

                       <div class="table-responsive">
                           <table class="table table-hover">
                               <thead class="table-light">
                                   <tr>
                                       <th>Course Code</th>
                                       <th>Course Name</th>
                                       <th>Teacher</th>
                                       <th>Marks</th>
                                       <th>Grade</th>
                                       <th>Remarks</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach($enrollment->semester->courses as $course)
                                       <tr>
                                           <td>{{ $course->code }}</td>
                                           <td>{{ $course->name }}</td>
                                           <td>{{ $course->teacher->name }}</td>
                                           @php
                                               $result = $enrollment->results
                                                   ->where('course_id', $course->course_id)
                                                   ->first();

                                               // Get all results for this course
                                               $allResults = isset($courseResults[$course->course_id])
                                                   ? $courseResults[$course->course_id]
                                                   : collect();


                                               // Get the latest result (if any)
                                               $latestResult = $allResults->first();
                                               // Get previous results (excluding the latest)
                                               $previousResults = $allResults->slice(1);
                                           @endphp
                                           @if($latestResult)
                                               <td>
                                                   {{ $latestResult->marks }}
                                                   @if($previousResults->isNotEmpty())
                                                       <div class="small text-muted">
                                                           Previous attempts:
                                                           @foreach($previousResults as $prevResult)
                                                               <br>{{ $prevResult->marks }} ({{ $prevResult->enrollment->semester->name }})
                                                           @endforeach
                                                       </div>
                                                   @endif
                                               </td>
                                               <td>
                                                   <span class="badge bg-{{ $latestResult->grade === 'F' ? 'danger' : ($latestResult->grade ? 'success' : 'secondary') }}">
                                                       {{ $latestResult->grade ?? 'Not Graded' }}
                                                   </span>
                                                   @if($previousResults->isNotEmpty())
                                                       <div class="small text-muted">
                                                           Previous attempts:
                                                           @foreach($previousResults as $prevResult)
                                                               <br>
                                                               <span class="badge bg-{{ $prevResult->grade === 'F' ? 'danger' : 'secondary' }}">
                                                                   {{ $prevResult->grade }}
                                                               </span>
                                                               ({{ $prevResult->enrollment->semester->name }})
                                                           @endforeach
                                                       </div>
                                                   @endif
                                               </td>
                                               <td>
                                                   <small class="text-muted">
                                                       {{ $latestResult->remarks ?? 'No remarks' }}
                                                       @if($previousResults->isNotEmpty())
                                                           <div class="mt-1">
                                                               Previous attempts:
                                                               @foreach($previousResults as $prevResult)
                                                                   <br>{{ $prevResult->remarks ?? 'No remarks' }}
                                                                   <em>({{ $prevResult->enrollment->semester->name }})</em>
                                                               @endforeach
                                                           </div>
                                                       @endif
                                                   </small>
                                               </td>
                                           @else
                                               <td colspan="3" class="text-center text-muted">
                                                   <small>Result not published yet</small>
                                               </td>
                                           @endif
                                       </tr>
                                   @endforeach
                               </tbody>
                               @if($enrollment->semester->courses->count() == $enrollment->results->count())
                                   <tfoot class="table-light">
                                       <tr>
                                           <td colspan="3" class="text-end"><strong>Semester GPA:</strong></td>
                                           <td colspan="3">
                                               <strong>
                                                   @php
                                                       $totalPoints = 0;
                                                       $totalCredits = 0;


                                                       foreach($enrollment->semester->courses as $course) {
                                                           // Get the latest result for this course if it exists
                                                           $latestResult = isset($courseResults[$course->course_id])
                                                               ? $courseResults[$course->course_id]->first()
                                                               : null;


                                                           if ($latestResult) {
                                                               $gradePoint = gradeToPoint($latestResult->grade);
                                                               $totalPoints += ($gradePoint * $course->credit);
                                                               $totalCredits += $course->credit;
                                                           }
                                                       }


                                                       $gpa = $totalCredits > 0 ? ($totalPoints / $totalCredits) : 0;
                                                   @endphp
                                                   {{ number_format($gpa, 2) }}
                                               </strong>
                                           </td>
                                       </tr>
                                   </tfoot>
                               @else
                                   <tfoot class="table-light">
                                       <tr>
                                           <td colspan="6" class="text-center text-muted">
                                               <em>Semester GPA will be published after all course results are available</em>
                                           </td>
                                       </tr>
                                   </tfoot>
                               @endif
                           </table>
                       </div>
                   </div>
               @endforeach
           @else
               <div class="alert alert-info">
                   No approved enrollments found. Results will appear here once your enrollment is approved.
               </div>
           @endif
       </div>
   </div>


   <!-- Add this modal at the bottom of your content section -->
   <div class="modal fade" id="updateProfileModal" tabindex="-1">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Update Profile</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
               </div>
               <form action="{{ route('student.profile.update', $student->student_id) }}" method="POST">
                   @csrf
                   @method('PUT')
                   <div class="modal-body">
                       <div class="mb-3">
                           <label for="name" class="form-label">Name</label>
                           <input type="text" class="form-control" id="name" name="name"
                               value="{{ $student->name }}" required>
                       </div>
                       <div class="mb-3">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" class="form-control" id="email" name="email"
                               value="{{ $student->email }}" required>
                       </div>
                       <div class="mb-3">
                           <label for="dob" class="form-label">Date of Birth</label>
                           <input type="date" class="form-control" id="dob" name="dob"
                               value="{{ $student->dob }}" required>
                       </div>
                       <div class="mb-3">
                           <label for="address" class="form-label">Address</label>
                           <textarea class="form-control" id="address" name="address"
                                   rows="3" required>{{ $student->address }}</textarea>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                       <button type="submit" class="btn btn-primary">Update Profile</button>
                   </div>
               </form>
           </div>
       </div>
   </div>
</div>
@endsection


@php
   function gradeToPoint($grade) {
       return match($grade) {
           'A+' => 4.00,
           'A'  => 3.75,
           'A-' => 3.50,
           'B+' => 3.25,
           'B'  => 3.00,
           'B-' => 2.75,
           'C+' => 2.50,
           'C'  => 2.25,
           'C-' => 2.00,
           'D+' => 1.75,
           'D'  => 1.50,
           'F'  => 0.00,
           default => 0.00
       };
   }
@endphp


