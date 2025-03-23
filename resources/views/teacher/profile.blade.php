@extends('layout.teacher')


@section('title')
Teacher Profile
@endsection


@section('heading')
Teacher Profile Dashboard
@endsection


@section('content')
<div class="container mt-4">
   <!-- Teacher Info Card -->
   <div class="card mb-4">
       <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
           <h3 class="mb-0">Teacher Information</h3>
           <a href="{{ route('teacher.results', $teacher->teacher_id) }}" class="btn btn-light">
               Manage Results
           </a>
       </div>
       <div class="card-body">
           <div class="row">
               <div class="col-md-6">
                   <table class="table table-borderless">
                       <tr>
                           <th width="30%">Teacher ID:</th>
                           <td>{{ $teacher->teacher_id }}</td>
                       </tr>
                       <tr>
                           <th>Name:</th>
                           <td>{{ $teacher->name }}</td>
                       </tr>
                       <tr>
                           <th>Email:</th>
                           <td>{{ $teacher->email }}</td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
   </div>


   <!-- Advisor Section - Enrollment Requests -->
   <div class="card">
       <div class="card-header bg-primary text-white">
           <h3 class="mb-0">Semester Enrollment Requests (As Advisor)</h3>
       </div>
       <div class="card-body">
           @if(session('success'))
               <div class="alert alert-success">
                   {{ session('success') }}
               </div>
           @endif


           @if(session('error'))
               <div class="alert alert-danger">
                   {{ session('error') }}
               </div>
           @endif


           @if($advisorEnrollments->count() > 0)
               <div class="table-responsive">
                   <table class="table table-hover">
                       <thead class="table-light">
                           <tr>
                               <th>Student</th>
                               <th>Session</th>
                               <th>Semester</th>
                               <th>Status</th>
                               <th>Enrolled On</th>
                               <th>Actions</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach($advisorEnrollments as $enrollment)
                                           <tr>
                                               <td>
                                                   {{ $enrollment->student->name }}
                                                   <div class="small text-muted">ID: {{ $enrollment->student->student_id }}</div>
                                               </td>
                                               <td>
                                                   {{ $enrollment->session->name }}
                                                   <div class="small text-muted">
                                                       {{ $enrollment->session->start_date }} - {{ $enrollment->session->end_date }}
                                                   </div>
                                               </td>
                                               <td>{{ $enrollment->semester->name }}</td>
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
                                               <td>
                                                   @if($enrollment->status === 'pending')
                                                       <div class="d-flex gap-1">
                                                           <!-- Approve Form -->
                                                           <form method="POST"
                                                               action="{{ route('teacher.enrollments.update-status', $enrollment->enrollment_id) }}">
                                                               @csrf
                                                               @method('PUT')
                                                               <input type="hidden" name="status" value="approved">
                                                               <button type="submit" class="btn btn-sm btn-success">
                                                                   Approve
                                                               </button>
                                                           </form>


                                                           <!-- Reject Form -->
                                                           <form method="POST"
                                                               action="{{ route('teacher.enrollments.update-status', $enrollment->enrollment_id) }}">
                                                               @csrf
                                                               @method('PUT')
                                                               <input type="hidden" name="status" value="rejected">
                                                               <button type="submit" class="btn btn-sm btn-danger">
                                                                   Reject
                                                               </button>
                                                           </form>
                                                       </div>
                                                   @endif
                                               </td>
                                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           @else
               <div class="alert alert-info">
                   No enrollment requests found for your advised semesters.
               </div>
           @endif
       </div>
   </div>
</div>
@endsection


