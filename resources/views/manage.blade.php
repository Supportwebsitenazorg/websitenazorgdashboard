@extends('layouts.app')

@section('content')
<div class="container">
    <div class="user-domains-section">
        <div class="card-header">
            <h3>@lang('messages.manage_own_team')</h3>
        </div>
        <hr>
        <div class="card-body">
            <form method="POST" action="{{ route('add-user-to-domain') }}" class="mb-3">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
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
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="userEmail">{{ __('messages.user_email') }}</label>
                            <input type="email" class="form-control" id="userEmail" name="user_email" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.add_user') }}</button>
            </form>
            <div class="accordion" id="accordionExample">
                @foreach ($organizations as $organization)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $organization->OrganizationID }}">
                        <button class="accordion-button collapsed justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $organization->OrganizationID }}" aria-expanded="false" aria-controls="collapse{{ $organization->OrganizationID }}">
                            {{ $organization->organization }}
                            <span class="accordion-collapse-icon"></span>
                        </button>
                    </h2>

                    <div id="collapse{{ $organization->OrganizationID }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $organization->OrganizationID }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @foreach ($organization->domains as $domain)
                            <strong>{{ __('messages.domain') }}:</strong> {{ $domain->domain }}
                            @if ($domain->users->isNotEmpty())
                            <table class="table user-domains-table">
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
        </div>
    </div>
</div>
@endsection
