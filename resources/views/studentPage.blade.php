@extends('layout.master')
@section('title')
Student Page
@endsection

@section('heading')
Student Details
@endsection

@section(section:'content')

    <table class="table">
       <thead>
        <tr>
            <th>Student Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date of Bath</th>
            <th>Address</th>
            <th>Password</th>
        </tr>
       </thead>
       <tbody>

        @foreach ($students as $student)

            <tr>
                <td>{{$student->student_id}}</td>
                <td>{{$student->name}}</td>
                <td>{{$student->email}}</td>
                <td>{{$student->dob}}</td>
                <td>{{$student->address}}</td>
                <td>{{$student->password}}</td>

            </tr>
         @endforeach
         </tbody>
    </table>

@endsection
