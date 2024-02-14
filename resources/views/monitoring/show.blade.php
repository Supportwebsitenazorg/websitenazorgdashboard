@extends('layouts.app')

@section('content')
<div class="container">
    @if(isset($data['error']))
        <div class="alert alert-danger">{{ $data['error'] }}</div>
    @else
        <div class="card">
            <div class="card-header">@lang('messages.monitoring_dashboard_for', ['domain' => $data['domain']])</div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>@lang('messages.issuer')</th>
                            <td>{{ $data['issuer'] }}</td>
                        </tr>
                        <tr>
                            <th>@lang('messages.expiration_date')</th>
                            <td>{{ $data['expirationDate']->toDateString() }}</td>
                        </tr>
                        <tr>
                            <th>@lang('messages.is_valid')</th>
                            <td>{{ $data['isValid'] ? trans('messages.yes') : trans('messages.no') }}</td>
                        </tr>

                        @if(isset($data['headers']) && is_array($data['headers']))
                        <tr>
                            <th>@lang('messages.headers')</th>
                            <td>
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
@endsection
