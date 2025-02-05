@extends('layout.master')
@section('title')
Teacher Page
@endsection

@section('heading')
Teacher Details
@endsection

@section(section:'teacherContent')

    <table class="table">
       <thead>
        <tr>
            <th>Teacher ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>



        </tr>
       </thead>
       <tbody>

        @foreach ($teacher as $teacher)

            <tr>
                <td>{{$teacher->teacher_id}}</td>
                <td>{{$teacher->name}}</td>
                <td>{{$teacher->email}}</td>
                <td>{{$teacher->password}}</td>

            </tr>
         @endforeach
         </tbody>
    </table>

@endsection
