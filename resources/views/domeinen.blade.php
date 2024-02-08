@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Domeinen') }}</div>
                <div class="card-body">
                    @if (Auth::user()->role === 'admin')
                        {{-- Admin's form to assign domains to users --}}
                        <form method="POST" action="{{ route('domains.assign') }}">
                            @csrf
                            <div class="form-group">
                                <label for="user_email">{{ __('Gebruiker Email') }}</label>
                                <select class="form-control" id="user_email" name="user_email" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="domain_name">{{ __('Domeinnaam') }}</label>
                                <input type="text" class="form-control" id="domain_name" name="domain_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Voeg Domein Toe') }}</button>
                        </form>
                        <hr>
                        <h3>Alle Domeinen:</h3>
                        @if (isset($allDomains) && $allDomains->isNotEmpty())
                            <ul>
                                @foreach ($allDomains as $domain)
                                    <li>{{ $domain->domain }} - {{ $domain->users->pluck('email')->join(', ') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Er zijn nog geen domeinen toegevoegd aan gebruikers.</p>
                        @endif
                    @else
                        {{-- Non-admin users' list of their own domains --}}
                        <h3>Mijn Domeinen:</h3>
                        @if (Auth::user()->domains->isNotEmpty())
                            <ul>
                                @foreach (Auth::user()->domains as $domain)
                                    <li>{{ $domain->domain }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Je hebt nog geen domeinen toegevoegd.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
