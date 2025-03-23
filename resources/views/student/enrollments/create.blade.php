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
           @if($failedCourses->count() > 0)
               <div class="alert alert-warning">
                   <h5>Failed Courses (Must Retake)</h5>
                   <ul>
                       @foreach($failedCourses as $result)
                           <li>
                               {{ $result->course->name }} ({{ $result->course->code }}) -
                               {{ $result->course->credit }} credits
                               [Failed in {{ $result->enrollment->semester->name }}]
                           </li>
                       @endforeach
                   </ul>
               </div>
           @endif


           <form action="{{ route('student.enrollments.store', $student_id) }}" method="POST">
               @csrf
               <div class="mb-3">
                   <label for="session_id">Academic Session</label>
                   <select name="session_id" class="form-control" required>
                       <option value="">Select Session</option>
                       @foreach($sessions as $session)
                           <option value="{{ $session->session_id }}"
                                   {{ old('session_id') == $session->session_id ? 'selected' : '' }}>
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
                           <option value="{{ $semester->semester_id }}"
                                   {{ old('semester_id') == $semester->semester_id ? 'selected' : '' }}>
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
                                               <th>Select</th>
                                               <th>Course Name</th>
                                               <th>Code</th>
                                               <th>Credit</th>
                                               <th>Teacher</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach($semester->courses as $course)
                                               <tr>
                                                   <td>
                                                       <div class="form-check">
                                                           <input type="checkbox"
                                                                  name="course_ids[]"
                                                                  value="{{ $course->course_id }}"
                                                                  class="form-check-input course-checkbox"
                                                                  data-credit="{{ $course->credit }}"
                                                                  {{ in_array($course->course_id, $failedCourses->pluck('course.course_id')->toArray()) ? 'checked disabled' : '' }}
                                                                  {{ (is_array(old('course_ids')) && in_array($course->course_id, old('course_ids'))) ? 'checked' : '' }}>
                                                       </div>
                                                   </td>
                                                   <td>{{ $course->name }}</td>
                                                   <td>{{ $course->code }}</td>
                                                   <td>{{ $course->credit }}</td>
                                                   <td>{{ $course->teacher->name }}</td>
                                               </tr>
                                           @endforeach
                                       </tbody>
                                   </table>
                               </div>


                               <div class="alert alert-info mt-3" id="credits-display">
                                   Total Selected Credits: <span class="total-credits">0</span>/28
                                   <div class="mt-2">
                                       <small class="text-muted">
                                           Failed Courses Credits: <span class="failed-credits">0</span>
                                       </small>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               @endforeach


               <div class="mt-4">
                   <button type="submit" class="btn btn-primary">Create Enrollment</button>
               </div>
           </form>
       </div>
   </div>
</div>


<script>
// Store failed courses data globally
let failedCoursesData = [];


// Initialize failed courses data when page loads
document.addEventListener('DOMContentLoaded', function() {
   console.log('Initializing failed courses data...');
   // Get all failed courses from the warning alert section
   const failedCoursesList = document.querySelectorAll('.alert-warning li');
   failedCoursesList.forEach(li => {
       const creditMatch = li.textContent.match(/(\d+\.?\d*)\s*credits/);
       if (creditMatch) {
           const credit = parseFloat(creditMatch[1]);
           console.log('Found failed course with credit:', credit);
           failedCoursesData.push({ credit: credit });
       }
   });
   console.log('Failed courses total:', failedCoursesData);
   updateTotalCredits();
});


function updateTotalCredits() {
   let failedCoursesTotal = 0;
   let newCoursesTotal = 0;

   // Calculate failed courses total from stored data
   failedCoursesTotal = failedCoursesData.reduce((sum, course) => sum + course.credit, 0);
   console.log('Failed courses total credits:', failedCoursesTotal);


   // Calculate new selections - include all checked checkboxes that are not disabled
   document.querySelectorAll('.course-checkbox:checked:not([disabled])').forEach(checkbox => {
       const credit = parseFloat(checkbox.dataset.credit || 0);
       newCoursesTotal += credit;
   });
   console.log('New courses total credits:', newCoursesTotal);


   const total = failedCoursesTotal + newCoursesTotal;
   console.log('Final total credits:', total);


   // Update all credit displays
   document.querySelectorAll('.total-credits').forEach(span => {
       span.textContent = total.toFixed(1);
   });


   document.querySelectorAll('.failed-credits').forEach(span => {
       span.textContent = failedCoursesTotal.toFixed(1);
   });

   // Visual feedback
   document.querySelectorAll('.alert-info').forEach(alertDiv => {
       if (total > 28) {
           alertDiv.classList.remove('alert-info');
           alertDiv.classList.add('alert-danger');
       } else {
           alertDiv.classList.remove('alert-danger');
           alertDiv.classList.add('alert-info');
       }
   });
}


function wouldExceedCreditLimit(checkbox) {
   const credit = parseFloat(checkbox.dataset.credit || 0);
   const failedCoursesTotal = failedCoursesData.reduce((sum, course) => sum + course.credit, 0);

   let currentTotal = failedCoursesTotal;
   document.querySelectorAll('.semester-courses:not([style*="none"]) .course-checkbox:checked:not([disabled])').forEach(cb => {
       if (cb !== checkbox) { // Don't count the checkbox being checked
           currentTotal += parseFloat(cb.dataset.credit || 0);
       }
   });

   return (currentTotal + credit) > 28;
}


// Add event listeners for checkboxes
document.querySelectorAll('.course-checkbox').forEach(checkbox => {
   checkbox.addEventListener('change', function(e) {
       if (!this.disabled) { // Only for non-failed courses
           if (this.checked && wouldExceedCreditLimit(this)) {
               e.preventDefault();
               this.checked = false;
               alert('Cannot select this course. Total credits would exceed 28.');
               return;
           }
           updateTotalCredits();
       }
   });
});


// Add event listener for semester selection
document.querySelector('select[name="semester_id"]').addEventListener('change', function() {
   document.querySelectorAll('.semester-courses').forEach(div => div.style.display = 'none');
   if (this.value) {
       document.getElementById('semester-' + this.value).style.display = 'block';
   }
   updateTotalCredits();
});


// Initial update
updateTotalCredits();
</script>
@endsection


