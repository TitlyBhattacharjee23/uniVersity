

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>@yield('title')</title>
   <!-- Bootstrap 5 CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <nav class="navbar navbar-expand-md navbar-dark bg-light shadow-sm">
       <div class="container">
           <a class="navbar-brand text-dark fw-light" href="{{ url('/') }}">
               Student Portal
           </a>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
               <span class="navbar-toggler-icon"></span>
           </button>


           <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <!-- Left Side Of Navbar -->
               <ul class="navbar-nav me-auto">
               </ul>


               <!-- Right Side Of Navbar -->
               <ul class="navbar-nav ms-auto">
                   @if(Auth::guard('student')->check())
                       <li class="nav-item dropdown">
                           <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button"
                              data-bs-toggle="dropdown" aria-expanded="false">
                               {{ Auth::guard('student')->user()->name }}
                           </a>


                           <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                               <a class="dropdown-item" href="{{ route('auth.logout') }}"
                                  onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                                   Logout
                               </a>


                               <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                                   @csrf
                               </form>
                           </div>
                       </li>
                   @else
                       <li class="nav-item">
                           <a class="nav-link text-dark" href="{{ route('auth.login') }}">Login</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link text-dark" href="{{ route('auth.register') }}">Register</a>
                       </li>
                   @endif
               </ul>
           </div>
       </div>
   </nav>


   <main class="py-4">
       @yield('content')
   </main>


   <!-- Bootstrap 5 JS Bundle with Popper -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

