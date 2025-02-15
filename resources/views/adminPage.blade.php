@extends('layout.master')
@section('title')
Admin Page
@endsection

@section('heading')
Admin Details
@endsection

@section(section:'content')

    <table class="table">
       <thead>
        <tr>
            <th>Admin ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
       </thead>
       <tbody>

        @foreach ($admin as $admin)

            <tr>
                <td>{{$admin->admin_id}}</td>
                <td>{{$admin->name}}</td>
                <td>{{$admin->email}}</td>
                <td>{{$admin->password}}</td>

            </tr>
         @endforeach
         </tbody>
    </table>

@endsection