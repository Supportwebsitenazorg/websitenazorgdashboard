@extends('layouts.app')
@section('content')
<div class="d-flex" style="min-height: 100vh;">
@include('layouts.sidebar', ['domain' => $domain])
<div class="flex-grow-1">
<div class="container p-5">
    @if(isset($data['error']))
        <div class="alert alert-danger">{{ $data['error'] }}</div>
    @else
        <div class="performance-score">
        <h2>@lang('messages.monitoring_dashboard_security', ['domain' => $data['domain']])</h2>
                <table class="table">
                    <tbody>   
                        @foreach($data['securityStatuses'] as $check => $status)
                            <tr>
                                <th class="bg-transparent">@lang('messages.' . $check)</th>
                                <td class="bg-transparent">
                                    <span class="badge {{ $status === 'Veilig' ? 'badge fs--1 w-25 badge-subtle-success' : ($status === 'Risico' ? 'badge fs--1 w-25 badge-subtle-warning' : 'badge fs--1 w-25 badge-subtle-danger') }}">
                                        @lang('messages.' . $status)
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
        <div class="performance-score">
            <h2>@lang('messages.monitoring_dashboard_security_specific', ['domain' => $data['domain']])</h2>
            <div class="card-body py-0">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="bg-transparent">@lang('messages.issuer')</th>
                            <td class="bg-transparent">{{ $data['issuer'] }}</td>
                        </tr>
                        <tr>
                            <th class="bg-transparent">@lang('messages.expiration_date')</th>
                            <td class="bg-transparent">{{ $data['expirationDate']->toDateString() }}</td>
                        </tr>
                        <tr>
                            <th class="bg-transparent">@lang('messages.is_valid')</th>
                            <td class="bg-transparent">{{ $data['isValid'] ? trans('messages.yes') : trans('messages.no') }}</td>
                        </tr>

                        <tr>
                            <th class="bg-transparent">@lang('messages.php_version')</th>
                            <td class="bg-transparent">
                                @if(is_array($data['phpVersion']))
                                    {{ implode(', ', $data['phpVersion']) }}
                                @else
                                    {{ $data['phpVersion'] != '0' ? $data['phpVersion'] : trans('messages.not_available') }}
                                @endif
                            </td>
                        </tr>
                        @if(isset($data['headers']) && is_array($data['headers']))
                            <tr>
                                <th class="bg-transparent">@lang('messages.headers')</th>
                                <td class="bg-transparent headers-container">
                                    <ul>
                                        @foreach($data['headers'] as $headerName => $headerValue)
                                            <li>{{ $headerName }}:</strong> {{ is_array($headerValue) ? implode(', ', $headerValue) : $headerValue }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
</div>
</div>
@endsection
