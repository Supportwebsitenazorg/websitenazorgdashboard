<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Websitenazorg | Registreren</title>
    <!-- Lettertypes -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <!-- Stijlen -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="container-fluid">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 welcome-text">Registreren</h1>
                        <h5>Maak een <span class="welcome-span">account</span> om toegang te krijgen.</h5>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Naam</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mailadres</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Wachtwoord</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Bevestig Wachtwoord</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="mb-0 text-center">
                            <button type="submit" class="btn btn-primary login-button ">
                                Registreren
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a class="btn welcome-buttons" href="{{ route('welcome') }}">Heb je al een account? Inloggen</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-rfqp7rWB6J3z5IXJyI5nLEHv5f3ue9f7/4z+b5pi5f5VA+o2m0v9yk7B5U5b5cF5w1"
        crossorigin="anonymous"></script>
</body>
</html>
