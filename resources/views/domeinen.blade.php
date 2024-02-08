@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Domeinen toevoegen') }}</div>
                <div class="card-body">
                    @if (Auth::user()->role === 'admin') {{-- Check if the user is an admin --}}
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
                    @endif
                    <h3>Mijn Domeinen:</h3>
                    @if (Auth::user()->domains->isNotEmpty())
                        <ul>
                            @foreach (Auth::user()->domains as $domain)
                                <li>{{ $domain->domain }}</li> {{-- Make sure 'domain' is the correct field name --}}
                            @endforeach
                        </ul>
                    @else
                        <p>Je hebt nog geen domeinen toegevoegd.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
