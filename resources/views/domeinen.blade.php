@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Domeinen') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('domains.add') }}">
                        @csrf
                        <div class="form-group">
                            <label for="domain_name">{{ __('Domeinnaam') }}</label>
                            <input type="text" class="form-control" id="domain_name" name="domain_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Voeg Domein Toe') }}</button>
                    </form>
                    <hr>
                    <h3>Mijn Domeinen:</h3>
                    @if (Auth::user()->domains->isNotEmpty())
                        <ul>
                            @foreach (Auth::user()->domains as $domain)
                                <li>{{ $domain->domain }}</li> {{-- Ensure this is the correct column name --}}
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
