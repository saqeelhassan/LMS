{{-- Student nav header (same UI as super-admin). b_logo when hamburger active. --}}
@php
    $logoUrl = null;
    $logoPath = \App\Models\Setting::get('logo');
    if ($logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath)) {
        $logoUrl = asset('storage/' . $logoPath);
    }
    if (!$logoUrl) {
        $logoUrl = asset('images/logo.svg');
    }
    $bLogoUrl = asset('Dsimt-lms-assets/images/b_logo.png');
@endphp
<div class="nav-header">
    <a href="{{ route('student.dashboard') }}" class="brand-logo">
        <img class="logo-abbr logo-default" src="{{ $logoUrl }}" alt="LMS" style="max-height: 38px; max-width: 140px; width: auto; height: auto; object-fit: contain;">
        <img class="logo-abbr logo-hamburger-active" src="{{ $bLogoUrl }}" alt="Digital Sindh" style="max-height: 38px; max-width: 140px; width: auto; height: auto; object-fit: contain;">
    </a>
    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
