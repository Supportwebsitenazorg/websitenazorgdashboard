@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="user-domains-section">
                <div class="card-header">{{ __('messages.profile_information') }}</div>
                <div class="card-body">
                    <p><strong>{{ __('messages.name') }}:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>{{ __('messages.email') }}:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>{{ __('messages.role') }}:</strong> 
                        @if (Auth::user()->role == 'user')
                            {{ __('messages.user') }}
                        @elseif (Auth::user()->role == 'orgadmin')
                            {{ __('messages.orgadmin') }}
                        @elseif (Auth::user()->role == 'admin')
                            {{ __('messages.admin') }}
                        @else
                            {{ __('messages.unknown') }}
                        @endif
                    </p>
                    <p><strong>{{ __('messages.member_since') }}:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="user-domains-section mt-4">
                <div class="card-header">{{ __('messages.remove_account') }}</div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('user.delete') }}">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <input type="text" name="confirmation_name" class="form-control" placeholder="{{ __('messages.enter_your_name') }}" required>
                        </div>
                        <button type="submit" class="btn btn-danger mt-2">{{ __('messages.remove_account') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
