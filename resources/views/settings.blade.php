@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Profiel informatie</div>
                <div class="card-body">
                    <p><strong>Naam:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>E-mail:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Websitenazorg-lid sinds:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
