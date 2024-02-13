@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('messages.manage_own_properties') }}</h2>
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('add-user-to-domain') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="domainSelect">{{ __('messages.select_domain') }}</label>
                            <select class="form-control" id="domainSelect" name="domain">
                                @foreach ($organizations as $organization)
                                    @foreach ($organization->domains as $domain)
                                        <option value="{{ $domain->domain }}">{{ $domain->domain }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userEmail">{{ __('messages.user_email') }}</label>
                            <input type="email" class="form-control" id="userEmail" name="user_email" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-1">{{ __('messages.add_user') }}</button>
            </form>
        </div>
    </div>

    @foreach ($organizations as $organization)
        <div>
            <div id="heading{{ $organization->OrganizationID }}">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $organization->OrganizationID }}" aria-expanded="false" aria-controls="collapse{{ $organization->OrganizationID }}">
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
                                </thead>
                                <tbody>
                                    @foreach ($domain->users as $user)
                                        <tr>
                                            <td>
                                                <a class="remove-user-email" data-email="{{ $user->email }}" data-domain="{{ $domain->domain }}" data-organization="{{ $organization->id }}">
                                                    {{ $user->email }}
                                                </a>
                                            </td>
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
