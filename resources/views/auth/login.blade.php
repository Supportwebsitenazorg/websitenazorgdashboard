<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Websitenazorg | Inloggen</title>
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
                        <h1 class="h3 mb-3 welcome-text">Inloggen</h1>
                        <h5>Inloggen voor <span class="welcome-span">direct</span> toegang.</h5>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mailadres</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Wachtwoord</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input form-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Onthoud mij
                                </label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary login-button">
                                Inloggen
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    @if (Route::has('password.request'))
                        <a class="btn welcome-buttons" href="{{ route('password.request') }}">
                            Wachtwoord vergeten?
                        </a>
                    @endif
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
