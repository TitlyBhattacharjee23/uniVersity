@extends('layout.admin')


@section('title')
    Admin Profile
@endsection


@section('heading')
    Admin Profile Dashboard
@endsection


@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Admin Information</h3>

                <div class="d-flex">
                    <a href="{{ route('admin.sessions.index', $admin->admin_id) }}" class="btn btn-light">
                        Manage Sessions
                    </a>
                    <a href="{{ route('admin.semesters.index', $admin->admin_id) }}" class="btn btn-light ms-2">
                        Manage Semesters
                    </a>

                </div>
            </div>

            <div class="card-body">
                <!-- Admin Info Display -->
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Admin ID:</th>
                                <td>{{ $admin->admin_id }}</td>
                            </tr>
                            <tr>
                                <th>Name:</th>
                                <td>{{ $admin->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $admin->email }}</td>
                            </tr>
                        </table>
                    </div>
                </div>


                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
