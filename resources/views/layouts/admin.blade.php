@extends('layouts.dashboard')

@section('sidebar-nav')
<p class="nav-section">Utama</p>
<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fa-solid fa-gauge-high"></i> Ringkasan
</a>

<p class="nav-section">Approval</p>
<a href="{{ route('admin.reservasi') }}" class="nav-link {{ request()->routeIs('admin.reservasi') ? 'active' : '' }}">
    <i class="fa-solid fa-calendar-check"></i> Reservasi
</a>
<a href="{{ route('admin.tenant') }}" class="nav-link {{ request()->routeIs('admin.tenant') ? 'active' : '' }}">
    <i class="fa-solid fa-handshake"></i> Permohonan tenant
</a>

<p class="nav-section">Keuangan</p>
<a href="{{ route('admin.keuangan') }}" class="nav-link {{ request()->routeIs('admin.keuangan') ? 'active' : '' }}">
    <i class="fa-solid fa-chart-line"></i> Laporan Keuangan
</a>
<a href="{{ route('admin.pajak') }}" class="nav-link {{ request()->routeIs('admin.pajak') ? 'active' : '' }}">
    <i class="fa-solid fa-receipt"></i> Pajak Tenant
</a>

<p class="nav-section">Koleksi E-RTIFACT</p>
<a href="{{ route('admin.artefak') }}" class="nav-link {{ request()->routeIs('admin.artefak') ? 'active' : '' }}">
    <i class="fa-solid fa-cube"></i> Artefak
</a>
<a href="{{ route('admin.tokoh') }}" class="nav-link {{ request()->routeIs('admin.tokoh') ? 'active' : '' }}">
    <i class="fa-solid fa-person-chalkboard"></i> Tokoh Penting
</a>
<a href="{{ route('admin.arsip') }}" class="nav-link {{ request()->routeIs('admin.arsip') ? 'active' : '' }}">
    <i class="fa-solid fa-scroll"></i> Arsip Sejarah
</a>
<a href="{{ route('admin.lokasi') }}" class="nav-link {{ request()->routeIs('admin.lokasi') ? 'active' : '' }}">
    <i class="fa-solid fa-map-location-dot"></i> Lokasi
</a>

<p class="nav-section">Manajemen</p>
<a href="{{ route('admin.buku-tamu.index') }}" class="nav-link {{ request()->routeIs('admin.buku-tamu.*') ? 'active' : '' }}">
    <i class="fa-solid fa-users"></i> Data Pengunjung
</a>
<a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
    <i class="fa-solid fa-calendar-alt"></i> Manajemen Event
</a>
<a href="{{ route('admin.tiket-bantuan.index') }}" class="nav-link {{ request()->routeIs('admin.tiket-bantuan.*') ? 'active' : '' }}">
    <i class="fa-solid fa-headset"></i> Bantuan Tenant
</a>
<a href="{{ route('admin.bantuan-publik.index') }}" class="nav-link {{ request()->routeIs('admin.bantuan-publik.*') ? 'active' : '' }}">
    <i class="fa-solid fa-envelope-open-text"></i> Bantuan Publik
</a>
@endsection
