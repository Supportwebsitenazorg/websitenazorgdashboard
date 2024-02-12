@extends('layouts.app')

@section('content')
<div class="container">
    <h1>@lang('messages.monitoring_dashboard_for', ['domain' => $data['domain']])</h1>
    @if(isset($data['error']))
        <div class="alert alert-danger">{{ $data['error'] }}</div>
    @else
        <div>
            <p>@lang('messages.issuer'): {{ $data['issuer'] }}</p>
            <p>@lang('messages.expiration_date'): {{ $data['expirationDate']->toDateString() }}</p>
            <p>@lang('messages.is_valid'): {{ $data['isValid'] ? trans('messages.yes') : trans('messages.no') }}</p>
        </div>
    @endif
</div>
@endsection
