@php
    $currentUrl = Request::path();
@endphp

<div class="d-flex flex-column flex-shrink-0 bg-white shadow-sm" style="width: 200px; height: auto;">
    <ul class="nav nav-pills flex-column mb-auto p-2">
        <li class="nav-item">
            <a href="/monitoring/{{ $domain }}" class="nav-link text-secondary {{ $currentUrl == "monitoring/$domain" ? 'active' : '' }}" aria-current="page">
                <i class="fa fa-shield-alt"></i> Beveiliging
            </a>
        </li>
        <li>
            <a href="/monitoring/{{ $domain }}/privacy" class="nav-link text-secondary {{ $currentUrl == "monitoring/$domain/privacy" ? 'active' : '' }}">
                <i class="fa fa-user-secret"></i> Privacy
            </a>
        </li>
        <li>
            <a href="/monitoring/{{ $domain }}/prestaties" class="nav-link text-secondary {{ $currentUrl == "monitoring/$domain/prestaties" ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt"></i> Prestaties
            </a>
        </li>
        <li>
            <a href="/monitoring/{{ $domain }}/duurzaamheid" class="nav-link text-secondary {{ $currentUrl == "monitoring/$domain/duurzaamheid" ? 'active' : '' }}">
                <i class="fa fa-leaf"></i> Duurzaamheid
            </a>
        </li>
        <li>
            <a href="/monitoring/{{ $domain }}/analyse-actie" class="nav-link text-secondary {{ $currentUrl == "monitoring/$domain/analyse-actie" ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i> Analyse & Actie
            </a>
        </li>
    </ul>
</div>