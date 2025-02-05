@extends('layout.master')
@section('title')
Advisor Page
@endsection

@section('heading')
Advisor Details
@endsection

@section(section:'advisorContent')

    <table class="table">
       <thead>
        <tr>
            <th>Admin ID</th>
            <th>Student ID</th>
            <th>Teacher ID</th>

        </tr>
       </thead>
       <tbody>

        @foreach ($advisor as $advisor)

            <tr>
                <td>{{$advisor->admin_id}}</td>
                <td>{{$advisor->student_id}}</td>
                <td>{{$advisor->teacher_id}}</td>


            </tr>
         @endforeach
         </tbody>
    </table>

@endsection
