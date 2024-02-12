@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('messages.manage_own_properties') }}</h1>
    @foreach ($organizations as $organization)
        <div class="card mb-3">
            <div class="card-header" id="heading{{ $organization->OrganizationID }}">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $organization->OrganizationID }}" aria-expanded="true" aria-controls="collapse{{ $organization->OrganizationID }}">
                        {{ $organization->organization }}
                    </button>
                </h5>
            </div>

            <div id="collapse{{ $organization->OrganizationID }}" class="collapse" aria-labelledby="heading{{ $organization->OrganizationID }}" data-bs-parent="#accordionExample">
                <div class="card-body">
                    @foreach ($organization->domains as $domain)
                        <strong>{{ __('messages.domain') }}:</strong> {{ $domain->domain }}
                        @if ($domain->users->isNotEmpty())
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('messages.email') }}</th>
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
                        @else
                            <p>{{ __('messages.no_users_found') }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
