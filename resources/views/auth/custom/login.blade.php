@extends('layout.student')


@section('title')
Login
@endsection


@section('content')
<div class="container mt-5">
   <div class="row justify-content-center">
       <div class="col-md-6">
           <div class="card">
               <div class="card-header text-black">
                   <h4 class="mb-0 fw-light">Login</h4>
               </div>


               <div class="card-body">
                   <form method="POST" action="{{ route('auth.login') }}">
                       @csrf


                       <!-- Email -->
                       <div class="mb-3">
                           <label for="email" class="form-label">Email Address</label>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                               name="email" value="{{ old('email') }}" placeholder="john@example.com">
                           @error('email')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <!-- Password -->
                       <div class="mb-3">
                           <label for="password" class="form-label">Password</label>
                           <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" placeholder="Enter your password">
                           @error('password')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <!-- Remember Me -->
                       {{-- <div class="mb-3">
                           <div class="form-check">
                               <input class="form-check-input" type="checkbox" name="remember" id="remember">
                               <label class="form-check-label" for="remember">
                                   Remember Me
                               </label>
                           </div>
                       </div> --}}


                       <!-- Submit Button -->
                       <div class="mb-3">
                           <button type="submit" class="btn btn-primary w-100">
                               Login
                           </button>
                       </div>


                       <!-- Register Link -->
                       <div class="text-center">
                           <a href="{{ route('auth.register') }}" class="text-decoration-none">
                               Need an account? Register here
                           </a>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
