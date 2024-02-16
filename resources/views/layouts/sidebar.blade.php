{{-- sidebar.blade.php --}}

@php
    $currentUrl = Request::path();
@endphp

<div class="d-flex flex-column flex-shrink-0 bg-light" style="width: 280px; height: 100vh;">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/monitoring/{{ $domain }}" class="nav-link text-black {{ $currentUrl == "monitoring/$domain" ? 'active' : '' }}" aria-current="page">
                Beveiliging
            </a>
        </li>
        <li>
            <a href="/monitoring/{{ $domain }}/privacy" class="nav-link text-black {{ $currentUrl == "monitoring/$domain/privacy" ? 'active' : '' }}">
                Privacy
            </a>
        </li>
        <li>
            <a href="/monitoring/{{ $domain }}/prestaties" class="nav-link text-black {{ $currentUrl == "monitoring/$domain/prestaties" ? 'active' : '' }}">
                Prestaties
            </a>
        </li>
        <li>
            <a href="/monitoring/{{ $domain }}/duurzaamheid" class="nav-link text-black {{ $currentUrl == "monitoring/$domain/duurzaamheid" ? 'active' : '' }}">
                Duurzaamheid
            </a>
        </li>
        <li>
            <a href="/monitoring/{{ $domain }}/analyse-actie" class="nav-link text-black {{ $currentUrl == "monitoring/$domain/analyse-actie" ? 'active' : '' }}">
                Analyse & Actie
            </a>
        </li>
    </ul>
</div>
