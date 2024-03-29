@extends('layouts.app')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    @include('layouts.sidebar', ['domain' => $domain])
    <div class="flex-grow-1">
        <div class="container p-5">
            @if(isset($todayInsights))
                <div class="performance-score">
                    <h2>{{ __('messages.performance_score') }}</h2>
                    <div class="d-flex justify-content-evenly align-items-center">
                        @php
                            $mobileScore = $todayInsights['mobile_score'] * 100;
                            $desktopScore = $todayInsights['desktop_score'] * 100;
                        @endphp
                        <div class="score">
                            <h3 class="text-center">{{ __('messages.Mobile') }}</h3>
                            <div class="score-circle">
                                <p class="score-value">{{ $mobileScore }}</p>
                            </div>
                        </div>
                        <div class="score">
                            <h3 class="text-center" style="color: #66b0ff ">{{ __('messages.Desktop') }}</h3>
                            <div class="score-circle" style="background: #66b0ff">
                                <p class="score-value">{{ $desktopScore }}</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                
                <div style="height: 500px; width: 100%;">
                    <canvas id="insightsChart"></canvas>
                </div>
            @else
                <p>{{ __('messages.no_insights_found') }}</p>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>window.insightsData = @json($insights);</script>
@vite(['resources/js/chartSetup.js'])
@endsection

