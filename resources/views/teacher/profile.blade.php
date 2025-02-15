@extends('layout.teacher')


@section('title')
Teacher Profile
@endsection


@section('heading')
Teacher Profile Dashboard
@endsection


@section('content')
<div class="container mt-4">
   <!-- Teacher Info Card -->
   <div class="card mb-4">
       <div class="card-header bg-primary text-white">
           <h3 class="mb-0">Teacher Information</h3>
       </div>
       <div class="card-body">
           <div class="row">
               <div class="col-md-6">
                   <table class="table table-borderless">
                       <tr>
                           <th width="30%">Teacher ID:</th>
                           <td>{{ $teacher->teacher_id }}</td>
                       </tr>
                       <tr>
                           <th>Name:</th>
                           <td>{{ $teacher->name }}</td>
                       </tr>
                       <tr>
                           <th>Email:</th>
                           <td>{{ $teacher->email }}</td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection

