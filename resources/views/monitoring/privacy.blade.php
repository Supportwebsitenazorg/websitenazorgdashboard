@extends('layouts.app')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
@include('layouts.sidebar', ['domain' => $domain])
<div class="flex-grow-1">
<div class="container">
    privacy
</div>
</div>
</div>
@endsection
