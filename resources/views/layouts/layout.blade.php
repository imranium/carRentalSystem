<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Car Booking System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
        }
        .navbar {
            background-color: #d32f2f; /* red */
        }
        .navbar a, .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        .footer {
            background-color: #212121; /* black */
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .main-content {
            min-height: 80vh;
            padding: 30px 15px;
        }
        .btn-primary {
            background-color: #d32f2f;
            border-color: #d32f2f;
        }
        .btn-primary:hover {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <div class="container main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <p class="mb-0"> ECE CarBooking - SW01082892 Sdn. Bhd. | 2025 | All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
