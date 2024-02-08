@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Profile Information') }}</div>
                <div class="card-body">
                    <p><strong>{{ __('Name') }}:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>{{ __('Email') }}:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>{{ __('Member Since') }}:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
