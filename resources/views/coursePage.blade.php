@extends('master')
@section('title')
Course Page
@endsection

@section('heading')
Course Details
@endsection

@section(section:'courseContent')

    <table class="table">
       <thead>
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Description</th>
            <th>Credits</th>
            <th>Capacity</th>

        </tr>
       </thead>
       <tbody>

        @foreach ($course as $course)

            <tr>
                <td>{{$course->course_id}}</td>
                <td>{{$course->course_name}}</td>
                <td>{{$course->credits}}</td>
                <td>{{$course->capacity}}</td>





            </tr>
         @endforeach
         </tbody>
    </table>

@endsection
