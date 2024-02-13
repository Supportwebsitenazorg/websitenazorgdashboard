@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('messages.manage_own_properties') }}</h2>
    @foreach ($organizations as $organization)
        <div>
            <div id="heading{{ $organization->OrganizationID }}">
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
                                    @foreach ($domain->users as $index => $user)
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
