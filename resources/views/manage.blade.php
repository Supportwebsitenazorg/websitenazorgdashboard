@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($organizations as $organization)
        <div class="mb-5">
            <h3>{{ $organization->organization }}</h3>
            @foreach ($organization->domains as $domain)
                <div class="card mb-3">
                    <div class="card-header">
                        Domein: {{ $domain->domain }}
                    </div>
                    <div class="card-body">
                        @if ($domain->users->isEmpty())
                            <p class="text-muted">Geen gebruikers gevonden.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">E-mail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($domain->users as $index => $user)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
