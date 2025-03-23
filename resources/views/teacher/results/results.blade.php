@extends('layout.teacher')


@section('title')
Manage Results
@endsection


@section('content')
<div class="container mt-4">
   <div class="card">
       <div class="card-header bg-primary text-white">
           <h3 class="mb-0">Manage Student Results</h3>
       </div>
       <div class="card-body">
           @foreach($courses as $courseData)
               <div class="mb-4">
                   <h4>{{ $courseData['course']->name }} ({{ $courseData['course']->code }})</h4>
                   <div class="table-responsive">
                       <table class="table table-hover">
                           <thead>
                               <tr>
                                   <th>Student</th>
                                   <th>Course Semester</th>
                                   <th>Enrollment Semester</th>
                                   <th>Enrollment Date</th>
                                   <th>Grade</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach($courseData['results'] as $result)
                                   <tr>
                                       <td>{{ $result->enrollment->student->name }}</td>
                                       <td>{{ $result->course->semester->name }}</td>
                                       <td><small class="text-muted">{{ $result->enrollment->semester->name }}</small></td>
                                       <td>{{ $result->enrollment->created_at->format('Y-m-d') }}</td>
                                       <td>
                                           @if($result->grade)
                                               <span class="badge bg-{{ $result->grade === 'F' ? 'danger' : 'success' }}">
                                                   {{ $result->grade }} ({{ $result->marks }})
                                               </span>
                                           @else
                                               <span class="text-muted">Not graded {{ $result->marks ? "($result->marks)" : '' }}</span>
                                           @endif
                                       </td>
                                       <td>
                                           <button type="button"
                                                   class="btn btn-warning btn-sm"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#resultModal{{ $result->enrollment->enrollment_id }}_{{ $result->course_id }}">
                                               Edit Result
                                           </button>
                                       </td>
                                   </tr>
                               @endforeach
                           </tbody>
                       </table>
                   </div>
               </div>
           @endforeach
       </div>
   </div>
</div>


<!-- Result Modals -->
@foreach($courses as $courseData)
   @foreach($courseData['results'] as $result)
       <div class="modal fade" id="resultModal{{ $result->enrollment->enrollment_id }}_{{ $result->course_id }}" tabindex="-1">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title">
                           Edit Result for {{ $result->enrollment->student->name }}
                           <small class="d-block text-muted">
                               Course Semester: {{ $result->course->semester->name }}<br>
                               Enrolled In: {{ $result->enrollment->semester->name }}
                           </small>
                       </h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                   </div>
                   <form action="{{ route('teacher.results.update') }}" method="POST">
                       @csrf
                       <input type="hidden" name="enrollment_id" value="{{ $result->enrollment->enrollment_id }}">
                       <input type="hidden" name="course_id" value="{{ $result->course_id }}">
                       <div class="modal-body">
                           <div class="mb-3">
                               <label for="marks">Marks</label>
                               <input type="number"
                                      name="marks"
                                      class="form-control"
                                      value="{{ $result->marks }}"
                                      required
                                      min="0"
                                      max="100"
                                      step="0.01">
                           </div>
                           <div class="mb-3">
                               <label for="grade">Grade</label>
                               <select name="grade" class="form-control" required>
                                   <option value="">Select Grade</option>
                                   @foreach(['A+','A','A-','B+','B','B-','C+','C','C-','D+','D','F'] as $grade)
                                       <option value="{{ $grade }}"
                                               {{ $result->grade === $grade ? 'selected' : '' }}>
                                           {{ $grade }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                           <div class="mb-3">
                               <label for="remarks">Remarks</label>
                               <textarea name="remarks"
                                         class="form-control"
                                         rows="3">{{ $result->remarks }}</textarea>
                           </div>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary">Update Result</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   @endforeach
@endforeach
@endsection


