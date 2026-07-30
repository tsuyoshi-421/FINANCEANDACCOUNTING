@props([
    'nexoraSrc' => null,
    'nexoraAlt' => 'Nexora ERP',
    'nexoraHref' => null,
    'showNexora' => true,
    'clientHref' => null,
    'nexoraHeight' => 96,
    'clientSize' => 64,
])

@php
    $clientLogo = null;
    $clientName = null;
    // Employees carry the client through their ERP session, while client ITSM
    // administrators are authenticated as main-app users.  Resolve either
    // identity, never a request-supplied client id, so a logo cannot leak
    // between companies.
    $clientId = (int) (session('employee_client_id') ?: auth()->user()?->company_id);

    if ($clientId > 0) {
        $client = \App\Models\Company::find($clientId);
        $clientLogo = $client?->logoUrl();
        $clientName = $client?->company_name;
    }

    $clientHref ??= \Illuminate\Support\Facades\Route::has('employee.portal')
        ? route('employee.portal')
        : '#';
@endphp

<div {{ $attributes->merge(['class' => 'nexora-client-brand']) }} style="display:flex;align-items:center;gap:14px;min-width:0;">
    @if($showNexora && $nexoraSrc)
        @if($nexoraHref)
            <a href="{{ $nexoraHref }}" aria-label="{{ $nexoraAlt }}" style="display:flex;align-items:center;flex:0 1 auto;min-width:0;">
                <img src="{{ $nexoraSrc }}" alt="{{ $nexoraAlt }}" style="height:{{ $nexoraHeight }}px;max-width:240px;object-fit:contain;object-position:left center;display:block;">
            </a>
        @else
            <img src="{{ $nexoraSrc }}" alt="{{ $nexoraAlt }}" style="height:{{ $nexoraHeight }}px;max-width:240px;object-fit:contain;object-position:left center;display:block;">
        @endif
    @endif

    @if($clientLogo)
        <a href="{{ $clientHref }}" title="Go to Employee Portal" aria-label="{{ $clientName }} Employee Portal" style="display:flex;align-items:center;justify-content:center;width:{{ $clientSize }}px;height:{{ $clientSize }}px;flex:0 0 {{ $clientSize }}px;border-radius:12px;background:rgba(255,255,255,.96);border:1px solid rgba(255,255,255,.35);box-shadow:0 2px 10px rgba(0,0,0,.18);overflow:hidden;">
            <img src="{{ $clientLogo }}" alt="{{ $clientName }} logo" style="width:100%;height:100%;object-fit:contain;padding:5px;display:block;">
        </a>
    @endif
</div>
