@extends('layouts.app')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    @include('layouts.sidebar', ['domain' => $domain])
    <div class="flex-grow-1">
        <div class="container">
            <h1>{{ $domain }}</h1>
            @if(isset($insights))

                <!-- Overall Performance Score -->
                <div class="performance-score">
                    <h2>Performance Score</h2>
                    <p>{{ $insights['lighthouseResult']['categories']['performance']['score'] * 100 }}</p>
                </div>

                <!-- Lab Data -->
                <div class="lab-data">
                    <h2>Lab Data</h2>
                    @foreach($insights['lighthouseResult']['audits'] as $auditKey => $audit)
                        @if(isset($audit['displayValue']) && !empty($audit['displayValue']))
                            <div>
                                <h3>{{ $audit['title'] }}</h3>
                                <p>{{ $audit['displayValue'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Opportunities -->
                <div class="opportunities">
                    <h2>Opportunities</h2>
                    @foreach($insights['lighthouseResult']['audits'] as $audit)
                        @if(isset($audit['details']) && $audit['details']['type'] === 'opportunity' && isset($audit['details']['overallSavingsMs']))
                            <div>
                                <h3>{{ $audit['title'] }}</h3>
                                <p>{{ $audit['description'] }}</p>
                                <p>Estimated savings: {{ $audit['details']['overallSavingsMs'] }} ms</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Diagnostics -->
                <div class="diagnostics">
                    <h2>Diagnostics</h2>
                    @foreach($insights['lighthouseResult']['audits'] as $audit)
                        @if(isset($audit['details']) && $audit['details']['type'] === 'diagnostic')
                            <div>
                                <h3>{{ $audit['title'] }}</h3>
                                <p>{{ $audit['description'] }}</p>
                                <!-- Display any diagnostic-specific details -->
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Passed Audits -->
                <div class="passed-audits">
                    <h2>Passed Audits</h2>
                    @foreach($insights['lighthouseResult']['audits'] as $audit)
                        @if($audit['score'] === 1)
                            <div>
                                <h3>{{ $audit['title'] }}</h3>
                                <p>{{ $audit['description'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Additional Information -->
                <div class="additional-information">
                    <h2>Additional Information</h2>
                    <p>Version: {{ $insights['lighthouseResult']['lighthouseVersion'] }}</p>
                    <p>Fetch Time: {{ $insights['lighthouseResult']['fetchTime'] }}</p>
                    <p>Analysis Time: {{ $insights['lighthouseResult']['timing']['total'] }}</p>
                </div>

            @elseif(isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
        </div>
    </div>
</div>
@endsection