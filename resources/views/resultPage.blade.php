@extends('master')
@section('title')
Result Page
@endsection

@section('heading')
Result Details
@endsection

@section(section:'resultContent')

    <table class="table">
       <thead>
        <tr>
            <th>Result ID</th>
            <th>Student ID</th>
            <th>Course ID</th>
            <th>CGPA ID</th>
            <th>Grade</th>


        </tr>
       </thead>
       <tbody>

        @foreach ($result as $result)

            <tr>
                <td>{{$result->result_id}}</td>
                <td>{{$result->student_id}}</td>
                <td>{{$result->course_id}}</td>
                <td>{{$result->cgpa}}</td>
                <td>{{$result->grade}}</td>


            </tr>
         @endforeach
         </tbody>
    </table>

@endsection
