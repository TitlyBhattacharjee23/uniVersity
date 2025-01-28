@extends('master')
@section('title')
Session Page
@endsection

@section('heading')
Session Details
@endsection

@section(section:'sessionContent')

    <table class="table">
       <thead>
        <tr>
            <th>Session ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>



        </tr>
       </thead>
       <tbody>

        @foreach ($session as $session)

            <tr>
                <td>{{$session->session_id}}</td>
                <td>{{$session->start_date}}</td>
                <td>{{$session->end_date}}</td>
                <td>{{$session->status}}</td>



            </tr>
         @endforeach
         </tbody>
    </table>

@endsection
