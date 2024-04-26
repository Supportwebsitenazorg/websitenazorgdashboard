<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('messages.login_title')</title>
    <link rel="icon" href="{{ asset('Logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
</head>
<body class="bg-white d-flex align-items-center justify-content-center min-vh-100">

    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h1 class="h3 mb-3 font-weight-bold">@lang('messages.login')</h1>
                    <h5>@lang('messages.login_access')</h5>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('messages.email')</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('messages.password')</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                @lang('messages.remember_me')
                            </label>
                        </div>
                    </div>

                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary d-block w-100 mt-3">
                            @lang('messages.login')
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                @if (Route::has('password.request'))
                    <a class="btn bg-white" href="{{ route('password.request') }}">
                        @lang('messages.forgot_password')
                    </a>
                @endif
                <a class="btn bg-white" href="{{ route('welcome') }}">@lang('messages.register')</a>
            </div>
        </div>
    </div>

</body>
</html>
