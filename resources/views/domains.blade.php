@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                @if (Auth::user()->role === 'admin')
                    <!-- Domain Assignment Form -->
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-white">@lang('messages.assign_domain')</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('domains.assign') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="user_email" class="form-label">@lang('messages.user_email')</label>
                                    <select class="form-select" id="user_email" name="user_email" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->email }}">{{ $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="domain_name" class="form-label">@lang('messages.domain_name')</label>
                                    <input type="text" class="form-control" id="domain_name" name="domain_name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">@lang('messages.add_domain')</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-white">@lang('messages.assign_organization')</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('organizations.assign') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="org_user_email" class="form-label">@lang('messages.user_email')</label>
                                    <select class="form-select" id="org_user_email" name="user_email" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->email }}">{{ $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="organization_name" class="form-label">@lang('messages.organization_name')</label>
                                    <input type="text" class="form-control" id="organization_name" name="organization_name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">@lang('messages.add_organization')</button>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <h3>
                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#domainsCollapse" aria-expanded="false" aria-controls="domainsCollapse">
                            @lang('messages.all_domains_assigned')
                        </button>
                    </h3>
                    <div class="collapse" id="domainsCollapse">
                        @if (isset($allDomains) && $allDomains->isNotEmpty())
                            <ul>
                                @foreach ($allDomains as $domain)
                                    <li>
                                        <a href="{{ route('monitoring.beveiliging', ['domain' => $domain->domain]) }}">
                                            {{ $domain->domain }}
                                        </a> - @lang('messages.assigned_to') 
                                        @foreach ($domain->users as $user)
                                            <span class="removable-user" data-domain="{{ $domain->domain }}" data-email="{{ $user->email }}">{{ $user->email }}</span>
                                        @endforeach
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>@lang('messages.no_domains_added')</p>
                        @endif
                    </div>
                    <h3>
                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#organizationsCollapse" aria-expanded="false" aria-controls="organizationsCollapse">
                            @lang('messages.all_organizations')
                        </button>
                    </h3>
                    <div class="collapse" id="organizationsCollapse">
                        @if (isset($allOrganizations) && $allOrganizations->isNotEmpty())
                            <ul>
                                @foreach ($allOrganizations as $organization)
                                    <li>{{ $organization->organization }} - @lang('messages.assigned_to')
                                        @foreach ($organization->users as $user)
                                            <span class="removable-user" data-organization="{{ $organization->organization }}" data-email="{{ $user->email }}">{{ $user->email }}</span>
                                        @endforeach
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>@lang('messages.no_organizations_added')</p>
                        @endif
                    </div>
                @else
                @if (Auth::user()->role === 'orgadmin')
    <div class="user-domains-section">
        <div class="form-group">
            <label for="select_organization">@lang('messages.select_organization')</label>
            <select class="form-control organization-select" id="select_organization">
                <option value="">@lang('messages.select_an_organization')</option>
                @foreach (Auth::user()->organizations as $organization)
                    <option value="{{ $organization->OrganizationID }}">{{ $organization->organization }}</option>
                @endforeach
            </select>
        </div>

        <div id="organization_domains" class="mt-3" style="display:none;">
            <ul id="domains_list" class="list-unstyled"></ul>
        </div>
    </div>
                    @elseif (Auth::user()->role === 'user')
                        <div class="user-domains-section">
                            <h3>@lang('messages.my_domains')</h3>
                            @if (isset($allDomains) && $allDomains->isNotEmpty())
                                <ul>
                                    @foreach ($allDomains as $domain)
                                        <li>
                                            <a href="{{ route('monitoring.beveiliging', ['domain' => $domain->domain]) }}">
                                                {{ $domain->domain }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="p-no-domains-message">@lang('messages.no_domains_added')</p>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
