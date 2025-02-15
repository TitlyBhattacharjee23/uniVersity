@extends('layout.student')


@section('title')
    Student Profile
@endsection


@section('heading')
    Student Profile Dashboard
@endsection


@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Student Information</h3>
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
                    Edit Profile
                </button>
            </div>

            <div class="card-body">
                <!-- Student Info Display -->
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Student ID:</th>
                                <td>{{ $student->student_id }}</td>
                            </tr>
                            <tr>
                                <th>Name:</th>
                                <td>{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $student->email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>Date of Birth:</th>
                                <td>{{ $student->dob }}</td>
                            </tr>
                            <tr>
                                <th width="30%">Address:</th>
                                <td>{{ $student->address }}</td>
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

        <!-- Add this modal at the bottom of your content section -->
        <div class="modal fade" id="updateProfileModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('student.profile.update', $student->student_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $student->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $student->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob"
                                    value="{{ $student->dob }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ $student->address }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
