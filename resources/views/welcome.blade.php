<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Websitenazorg+</title>
    <link rel="icon" href="{{ asset('Logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="container-fluid">

    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                    <img src="{{ asset('/Logo.png') }}" alt="Logo van Websitenazorg">
                        <h1 class="h3 mb-3 welcome-text pt-5">Welkom</h1>
                        <h5>Log in bij <span class="welcome-span" >Websitenazorg+</span> om toegang te krijgen tot het dashboard.</h5>


                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn welcome-buttons" href="{{ route('login') }}">Inloggen</a>
                    <a class="btn welcome-buttons" href="{{ route('register') }}">Registreren</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-rfqp7rWB6J3z5IXJyI5nLEHv5f3ue9f7/4z+b5pi5f5VA+o2m0v9yk7B5U5b5cF5w1"
        crossorigin="anonymous"></script>
</body>
</html>
