@extends('layouts.app')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    @include('layouts.sidebar', ['domain' => $domain])
    <div class="flex-grow-1">
        <div class="container p-5">
            <div class="performance-score">
                <h2>{{ __('messages.privacy_details') }}</h2>
                <h4>{{ __('messages.third_pary_services') }}</h4>
                <table class="table">
                    <tbody>
                        @forelse ($trackers['trackers'] as $tracker)
                            <tr>
                                <th class="bg-transparent">{{ $tracker }}</th>
                            </tr>
                        @empty
                            <tr>
                                <th class="bg-transparent">{{ __('messages.free_from_wellknown_trackers') }}</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <h4>{{ __('Cookies') }}</h4>
                <table class="table">
                    <tbody>
                        @forelse ($trackers['cookies'] as $cookie)
                            <tr>
                                <th class="bg-transparent">{{ __('messages.Cookie') }}</th>
                                <td class="bg-transparent line-break">{{ $cookie }}</td>
                            </tr>
                        @empty
                            <tr>
                                <th class="bg-transparent">{{ __('messages.free_from_wellknown_cookies') }}</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
