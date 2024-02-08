@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('messages.profile_information') }}</div> 
                <div class="card-body">
                    <p><strong>{{ __('messages.name') }}:</strong> {{ Auth::user()->name }}</p> 
                    <p><strong>{{ __('messages.email') }}:</strong> {{ Auth::user()->email }}</p> 
                    <p><strong>{{ __('messages.member_since') }}:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
