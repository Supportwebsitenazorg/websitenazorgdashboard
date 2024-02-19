@extends('layouts.app')

@section('content')
<div class="container p-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('messages.verify_email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('messages.verification_link_sent') }}
                        </div>
                    @endif

                    {{ __('messages.check_email_verification') }}
                    {{ __('messages.did_not_receive_email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('messages.click_here_to_request') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
