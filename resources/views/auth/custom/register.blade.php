@extends('layout.student')


@section('title')
Student Registration
@endsection


@section('content')
<div class="container mt-5">
   <div class="row justify-content-center">
       <div class="col-md-6">
           <div class="card">
               <div class="card-header text-black">
                   <h4 class="mb-0 fw-light">Student Registration</h4>
               </div>


               <div class="card-body">
                   <form method="POST" action="{{ route('auth.register') }}">
                       @csrf


                       <!-- Name -->
                       <div class="mb-3">
                           <label for="name" class="form-label">Full Name</label>
                           <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="John Doe">
                           @error('name')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <!-- Email -->
                       <div class="mb-3">
                           <label for="email" class="form-label">Email Address</label>
                           <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="john@example.com">
                           @error('email')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <!-- Date of Birth -->
                       <div class="mb-3">
                           <label for="dob" class="form-label">Date of Birth</label>
                           <input type="date"
                               class="form-control @error('dob') is-invalid @enderror"
                               id="dob"
                               name="dob"
                               value="{{ old('dob') }}">
                           @error('dob')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <!-- Address -->
                       <div class="mb-3">
                           <label for="address" class="form-label">Address</label>
                           <textarea class="form-control @error('address') is-invalid @enderror"
                               id="address"
                               name="address"
                               rows="2"
                               placeholder="Your current address">{{ old('address') }}</textarea>
                           @error('address')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <!-- Password -->
                       <div class="mb-3">
                           <label for="password" class="form-label">Password</label>
                           <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Enter your password">
                           @error('password')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <!-- Confirm Password -->
                       <div class="mb-3">
                           <label for="password_confirmation" class="form-label">Confirm Password</label>
                           <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Confirm your password">
                       </div>


                       <!-- Submit Button -->
                       <div class="mb-3">
                           <button type="submit" class="btn btn-primary w-100">
                               Register
                           </button>
                       </div>


                       <!-- Login Link -->
                       <div class="text-center">
                           <a href="{{ route('auth.login') }}" class="text-decoration-none">
                               Already have an account? Login here
                           </a>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
