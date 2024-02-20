@extends('layouts.app')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    @include('layouts.sidebar', ['domain' => $domain])
    <div class="flex-grow-1">
        <div class="container p-5">
            @if(isset($insights))
                <div class="performance-score">
                    <h2>{{ __('messages.performance_score') }}</h2>
                    <div class="score-circle {{ $insights['lighthouseResult']['categories']['performance']['score'] * 100 >= 90 ? 'good' : ($insights['lighthouseResult']['categories']['performance']['score'] * 100 >= 50 ? 'average' : 'bad') }}">
                        <p class="score-value">{{ $insights['lighthouseResult']['categories']['performance']['score'] * 100 }}</p>
                    </div>
                </div>
                <div class="lab-data">
                    <h2>{{ __('messages.lab_data') }}</h2>
                    @foreach($insights['lighthouseResult']['audits'] as $auditKey => $audit)
                        @if(isset($audit['displayValue']) && !empty($audit['displayValue']))
                            <div>
                                <h3>{{ $audit['title'] }}</h3>
                                <p>{{ $audit['displayValue'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="opportunities">
                    <h2>{{ __('messages.opportunities') }}</h2>
                    @foreach($insights['lighthouseResult']['audits'] as $audit)
                        @if(isset($audit['details']) && $audit['details']['type'] === 'opportunity' && isset($audit['details']['overallSavingsMs']))
                            <div>
                                <h3>{{ $audit['title'] }}</h3>
                                <p>{{ $audit['description'] }}</p>
                                <p>{{ __('messages.estimated_savings') }}: {{ $audit['details']['overallSavingsMs'] }} ms</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="diagnostics">
                    <h2>{{ __('messages.diagnostics') }}</h2>
                    @foreach($insights['lighthouseResult']['audits'] as $audit)
                        @if(isset($audit['details']) && $audit['details']['type'] === 'diagnostic')
                            <div>
                                <h3>{{ $audit['title'] }}</h3>
                                <p>{{ $audit['description'] }}</p>
                                @if(isset($audit['details']['items']))
                                    @foreach($audit['details']['items'] as $item)
                                        <div class="diagnostic-detail">
                                            @foreach($item as $key => $value)
                                                <p><strong>{{ $key }}:</strong> {{ $value }}</p>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="passed-audits">
                    <h2>{{ __('messages.passed_audits') }}</h2>
                    @foreach($insights['lighthouseResult']['audits'] as $audit)
                        @if($audit['score'] === 1)
                            <div>
                                <h3>{{ $audit['title'] }}</h3>
                                <p>{{ $audit['description'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="additional-information">
                    <h2>{{ __('messages.additional_information') }}</h2>
                    <p>{{ __('messages.version') }}: {{ $insights['lighthouseResult']['lighthouseVersion'] }}</p>
                    <p>{{ __('messages.fetch_time') }}: {{ $insights['lighthouseResult']['fetchTime'] }}</p>
                    <p>{{ __('messages.analysis_time') }}: {{ $insights['lighthouseResult']['timing']['total'] }}</p>
                </div>
            @elseif(isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
