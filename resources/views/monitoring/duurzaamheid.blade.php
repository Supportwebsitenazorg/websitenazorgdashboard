@php
$ratingScale = [
    'A+' => 0.0,
    'A'  => 0.167,
    'B'  => 0.333,
    'C'  => 0.5,
    'D'  => 0.667,
    'E'  => 0.833,
    'F'  => 0.980,
];

function getCarbonRating($co2PerPageview, $ratingScale) {
    foreach ($ratingScale as $rating => $threshold) {
        if ($co2PerPageview <= $threshold) {
            return $rating;
        }
    }
    return 'F';
}

$currentRating = getCarbonRating($carbonDetails['statistics']['co2']['grid']['grams'], $ratingScale);

$ratingClass = 'rating-' . str_replace('+', '-plus', $currentRating);

$co2PerPageview = $carbonDetails['statistics']['co2']['grid']['grams'];

if ($co2PerPageview <= 0.095) {
    $indicatorPosition = 0;
} elseif ($co2PerPageview <= 0.186) {
    $indicatorPosition = 20;
} elseif ($co2PerPageview <= 0.341) {
    $indicatorPosition = 40;
} elseif ($co2PerPageview <= 0.493) {
    $indicatorPosition = 60;
} elseif ($co2PerPageview <= 0.656) {
    $indicatorPosition = 80;
} elseif ($co2PerPageview <= 0.846) {
    $indicatorPosition = 90;
} else {
    $indicatorPosition = 100;
}
@endphp

@extends('layouts.app')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    @include('layouts.sidebar', ['domain' => $domain])
    <div class="flex-grow-1">
        <div class="container p-7">
            @if(isset($carbonDetails))
            <div class="w-100 white-bg-stain pt-4 pb-5">
                <div class="carbon-rating-container">
                    <div class="carbon-rating-bar">
                        <div class="carbon-rating-indicator" style="left: {{ $indicatorPosition }}%;"></div>
                    </div>
                    <div class="carbon-rating-label">
                        @foreach($ratingScale as $rating => $threshold)
                            <span class="h3 text-blue" style="position: absolute; left: {{ ($threshold * 100) }}%;">{{ $rating }}</span>
                        @endforeach
                    </div>
                </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="w-50 white-bg-stain pb-5 mt-5">
                        <h3 class="mt-5 text-blue text-center">{{ __('messages.CO2_per_page_view') }} <br> 
                            <strong class="text-white co2-font {{ $carbonDetails['green'] ? 'blue-bg' : 'red-bg' }}">
                                {{ number_format($carbonDetails['statistics']['co2']['grid']['grams'], 2) }} {{ __('messages.gram') }}
                            </strong> 
                            {{ __('messages.This_website_is') }} 
                            <strong class="{{ $carbonDetails['green'] ? 'green-bg' : 'red-bg' }} co2-font text-white">
                                {{ $carbonDetails['green'] ? __('messages.hosted_on_a_green_server') : __('messages.not_hosted_on_a_green_server') }}.
                            </strong>
                        </h3>
                    </div>
                </div>
                <div class="w-50 white-bg-stain pb-5 mt-5">
                    <h3 class="mt-5 text-center text-blue">{{ __('messages.It_is_cleaner_than') }} <br> <strong class="blue-bg co2-font text-white">{{ number_format($carbonDetails['cleanerThan'] * 100, 2) }}%</strong> {{ __('messages.of_tested_websites') }}.</h3>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="w-50 white-bg-stain pb-5 mt-5">
                        <h3 class="mt-5 text-center text-blue">{{ __('messages.In_a_year_with_10_000_monthly_pageviews') }} <br> {{ __('messages.this_site_produces') }} <strong class="text-white blue-bg co2-font">{{ number_format($carbonDetails['statistics']['co2']['grid']['grams'] * 12000 / 1000, 2) }}kg</strong> CO2-equivalent.</h3>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="w-50 white-bg-stain pb-5 mt-5">
                        <h3 class="mt-5 text-center text-blue">{{ __('messages.That_is_equal_to_CO2_as_boiling_water_for') }} <br> <strong class="text-white blue-bg">{{ number_format(($carbonDetails['statistics']['co2']['grid']['grams'] * 12000) / 15, 0) }}</strong> {{ __('messages.cups_of_tea') }}.</h3>
                    </div>
                </div>
                <div class="d-flex justify-content-start">
                    <div class="w-50 white-bg-stain pb-5 mt-5">
                        <h3 class="mt-5 text-center text-blue">{{ __('messages.Or_enough_electricity_to_drive_an_electric_car') }} <br> <strong class="text-white blue-bg">{{ number_format(($carbonDetails['statistics']['energy'] * 12000) / 0.15, 0) }}km</strong> {{ __('messages.to_drive') }}.</h3>
                    </div>
                </div>
            @elseif(isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
