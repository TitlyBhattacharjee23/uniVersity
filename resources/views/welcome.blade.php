<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>P.A.S.T University - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap & Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f4f4f4;
        }

        .gradient-bg {
            background: linear-gradient(to right, #1e3c72, #2a5298);
        }

        .header-container {
            text-align: center;
            padding: 30px 15px;
            background-color: #2a5298;
            color: white;
        }

        .header-title {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* .header-subtitle {
            font-size: 20px;
            font-weight: bold;
        } */
        .intro-text {
            text-align: center;
            font-size: 25px;
            color: #444;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .login-container {
            width: 100%;
            height: 100%;
            max-width: 420px;
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: -10px;
        }

        .btn-custom {
            background: #2a5298;
            color: white;
            transition: 0.3s;
            font-size: 20px;
        }

        .btn-custom:hover {
            background: #1e3c72;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <div class="header-container">
        <h1 class="header-title">Welcome to P.A.S.T University!</h1>
        <!-- <p class="header-subtitle">P.A.S.T University</p> -->
    </div>

    <!-- Introduction Text -->
    <p class="intro-text">
        Join our platform for seamless access to academic resources, faculty connections, and student support. <br>
        Log in or register to explore our educational ecosystem.
    </p>

    <!-- Login Section -->
    <div class="min-h-screen flex items-center justify-center">
        <div class="login-container", style="margin-top: 5px;", style="margin-bottom: 50px;">

            <div class="space-y-3 mb-4">
                @if (Auth::guard('student')->check())
                    <a href="/student/[{{ Auth::guard('student')->user()->student_id }}]" class="btn btn-custom w-100">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('auth.login') }}" class="btn btn-custom w-100">
                        Login
                    </a>
                    <a href="{{ route('auth.register') }}" class="btn btn-outline-primary w-100">
                        Register as a Student
                    </a>
                @endif
            </div>
            <!-- <h2 class="text-center text-xl font-bold text-gray-800 mb-3">University Login</h2> -->
            {{-- @if (Route::has('login'))
                <div class="space-y-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-custom w-100">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-custom w-100">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary w-100", font-size: 25>
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif --}}
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white py-3 gradient-bg">
        <p class="mb-0">&copy; 2025 P.A.S.T University. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
