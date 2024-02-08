@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.domains_and_organizations')</div>
                <div class="card-body">
                    @if (Auth::user()->role === 'admin')
                        {{-- Admin's form to assign domains to users --}}
                        <form method="POST" action="{{ route('domains.assign') }}">
                            @csrf
                            <div class="form-group">
                                <label for="user_email">@lang('messages.user_email')</label>
                                <select class="form-control" id="user_email" name="user_email" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="domain_name">@lang('messages.domain_name')</label>
                                <input type="text" class="form-control" id="domain_name" name="domain_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">@lang('messages.add_domain')</button>
                        </form>
                        <hr>
                        {{-- Admin's form to assign organizations to users --}}
                        <form method="POST" action="{{ route('organizations.assign') }}">
                            @csrf
                            <div class="form-group">
                                <label for="user_email">@lang('messages.user_email')</label>
                                <select class="form-control" id="user_email" name="user_email" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="organization_name">@lang('messages.organization_name')</label>
                                <input type="text" class="form-control" id="organization_name" name="organization_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">@lang('messages.add_organization')</button>
                        </form>
                        <hr>
                        <h3>@lang('messages.all_domains_and_organizations')</h3>
                        @if (isset($allDomains) && $allDomains->isNotEmpty())
                            <ul>
                                @foreach ($allDomains as $domain)
                                    <li>{{ $domain->domain }} - @lang('messages.assigned_to') {{ $domain->users->pluck('email')->join(', ') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>@lang('messages.no_domains_added')</p>
                        @endif
                        <h3>@lang('messages.all_organizations')</h3>
                        @if (isset($allOrganizations) && $allOrganizations->isNotEmpty())
                            <ul>
                                @foreach ($allOrganizations as $organization)
                                    <li>{{ $organization->organization }} - @lang('messages.assigned_to') {{ $organization->users->pluck('email')->join(', ') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>@lang('messages.no_organizations_added')</p>
                        @endif
                    @else
                        {{-- Non-admin users' list of their own domains --}}
                        <h3>@lang('messages.my_domains')</h3>
                        @if (Auth::user()->domains->isNotEmpty())
                            <ul>
                                @foreach (Auth::user()->domains as $domain)
                                    <li>{{ $domain->domain }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>@lang('messages.no_domains_added')</p>
                        @endif
                        {{-- Non-admin users' list of their own organizations --}}
                        <h3>@lang('messages.my_organizations')</h3>
                        @if (Auth::user()->organizations->isNotEmpty())
                            <ul>
                                @foreach (Auth::user()->organizations as $organization)
                                    <li>{{ $organization->organization }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>@lang('messages.no_organizations_added')</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
