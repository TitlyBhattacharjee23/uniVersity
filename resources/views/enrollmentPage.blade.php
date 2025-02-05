@extends('layout.master')
@section('title')
Enrollment Page
@endsection

@section('heading')
Enrollment Details
@endsection

@section(section:'enrollContent')

    <table class="table">
       <thead>
        <tr>
            <th>Enrollment ID</th>
            <th>Student ID</th>
            <th>Course ID</th>
            <th>Enrollment Date</th>

        </tr>
       </thead>
       <tbody>

        @foreach ($enrollment as $enrollment)

            <tr>
                <td>{{$enrollment->enrollment_id}}</td>
                <td>{{$enrollment->student_id}}</td>
                <td>{{$enrollment->course_id}}</td>

            </tr>
         @endforeach
         </tbody>
    </table>

@endsection
