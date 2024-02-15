<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('messages.title')</title>
    <link rel="icon" href="{{ asset('Logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('/Logo.png') }}" alt="@lang('messages.title')">
                            <h1 class="h3 mb-3 welcome-text pt-5">@lang('messages.welcome')</h1>
                            <h5>@lang('messages.login_message')</h5>
                            <div class="language-switcher">
                                <select onchange="changeLanguage(this)">
                                    <option value="nl"{{ app()->getLocale() == 'nl' ? ' selected' : '' }}>@lang('messages.dutch')</option>
                                    <option value="en"{{ app()->getLocale() == 'en' ? ' selected' : '' }}>@lang('messages.english')</option>
                                    <option value="hi"{{ app()->getLocale() == 'hi' ? ' selected' : '' }}>@lang('messages.hindi')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn welcome-buttons" href="{{ route('login') }}">@lang('messages.login')</a>
                        <a class="btn welcome-buttons" href="{{ route('register') }}">@lang('messages.register')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function changeLanguage(select) {
            window.location.href = "{{ url('language') }}/" + select.value;
        }
    </script>
</body>
</html>
