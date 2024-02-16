@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('card_title_1') }}</div>
                    <div class="card-body">
                        <p>een</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('card_title_2') }}</div>
                    <div class="card-body">
                        <p>twee</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('card_title_3') }}</div>
                    <div class="card-body">
                        <p>drie</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('card_title_4') }}</div>
                    <div class="card-body">
                        <p>vier</p>
                    </div>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('card_title_5') }}</div>
                <div class="card-body">
                    <p>vijf lang</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
