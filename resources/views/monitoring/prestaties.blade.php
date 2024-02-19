@extends('layouts.app')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
@include('layouts.sidebar', ['domain' => $domain])
<div class="flex-grow-1">
<div class="container">
    <h1>Prestaties for {{ $domain }}</h1>
    @if(isset($insights))
        <div>First Contentful Paint: {{ $insights['lighthouseResult']['audits']['first-contentful-paint']['displayValue'] }}</div>
        <!-- Add more metrics as needed -->
    @elseif(isset($error))
        <div>{{ $error }}</div>
    @endif
</div>
</div>
</div>
@endsection
