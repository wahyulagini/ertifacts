@extends('layouts.dashboard')

@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')
@section('page-subtitle', 'Informasi lengkap reservasi Anda')

@section('sidebar-nav')
    <p class="nav-section">Menu Utama</p>
    <a href="{{ route('pengunjung.dashboard') }}" class="nav-link {{ request()->routeIs('pengunjung.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i> Beranda
    </a>
    <a href="{{ route('pengunjung.reservasi.create') }}" class="nav-link {{ request()->routeIs('pengunjung.reservasi.create') ? 'active' : '' }}">
        <i class="fa-solid fa-calendar-plus"></i> Buat Reservasi
    </a>
    <a href="{{ route('pengunjung.reservasi.index') }}" class="nav-link {{ request()->routeIs('pengunjung.reservasi.index', 'pengunjung.reservasi.show') ? 'active' : '' }}">
        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Reservasi
    </a>

    <p class="nav-section">Koleksi Museum</p>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-cube"></i> Artefak & 3D
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-person-chalkboard"></i> Tokoh Penting
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-scroll"></i> Arsip Sejarah
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-map-location-dot"></i> Peta Lokasi
    </a>

    <p class="nav-section">Akun</p>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-user-pen"></i> Edit Profil
    </a>
@endsection

@section('content')
<div class="max-w-2xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-brand-100 flex justify-between items-center">
        <h3 class="font-bold text-brand-800 text-sm">Kode: {{ $reservasi->kode_booking }}</h3>
        <span class="badge {{ $reservasi->status == 'menunggu' ? 'badge-yellow' : ($reservasi->status == 'disetujui' ? 'badge-green' : ($reservasi->status == 'dibatalkan' || $reservasi->status == 'ditolak' ? 'badge-red' : 'badge-blue')) }}">
            {{ ucfirst($reservasi->status) }}
        </span>
    </div>
    <div class="p-5 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-brand-400">Jenis Kunjungan</p>
                <p class="font-semibold text-brand-800 text-sm">{{ $reservasi->jenis }}</p>
            </div>
            <div>
                <p class="text-xs text-brand-400">Tanggal Kunjungan</p>
                <p class="font-semibold text-brand-800 text-sm">{{ \Carbon\Carbon::parse($reservasi->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-brand-400">Sesi</p>
                <p class="font-semibold text-brand-800 text-sm">{{ $reservasi->sesi }}</p>
            </div>
            <div>
                <p class="text-xs text-brand-400">Jumlah Orang</p>
                <p class="font-semibold text-brand-800 text-sm">{{ $reservasi->jumlah_orang }} Orang</p>
            </div>
        </div>

        <div>
            <p class="text-xs text-brand-400">Keperluan</p>
            <p class="font-semibold text-brand-800 text-sm">{{ $reservasi->keperluan ?? '-' }}</p>
        </div>

        @if($reservasi->status == 'menunggu')
        <div class="pt-4 border-t border-brand-100 flex justify-end">
            <form action="{{ route('pengunjung.reservasi.cancel', $reservasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                @csrf
                <button type="submit" class="btn-primary !bg-red-600 !from-red-600 !to-red-700">Batalkan Reservasi</button>
            </form>
        </div>
        @endif
        
        <div class="pt-4 border-t border-brand-100 flex justify-end">
            <a href="{{ route('pengunjung.reservasi.index') }}" class="btn-outline">Kembali</a>
        </div>
    </div>
</div>
@endsection
